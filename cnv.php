<?php

function strStartWith($str, $pref) {
    return substr($str, 0, strlen($pref)) == $pref;
}

function splitArgs($cfg) {
    return preg_split("/\\s+/", $cfg);
}

$cfg_count = 0;
$cfg_rinetd = explode("\n", file_get_contents("rinetd.conf"));
$cfg_haproxy = "
global
    daemon
    maxconn 10000

defaults
    timeout connect 500s
    timeout client 5000s
    timeout server 1h
";
$rule_template = "
frontend frontend%d
    bind %s:%s
    default_backend backend%d

backend backend%d
    mode tcp
    server target%d %s:%s
";


foreach ($cfg_rinetd as $cfg) {
    $cfg = trim($cfg);
    if (strStartWith($cfg, "#"))
        continue;
    else {
        $args = splitArgs($cfg);
        if (count($args) == 4) {
            $cfg_haproxy .= sprintf($rule_template,
                $cfg_count, $args[0], $args[1], $cfg_count,
                $cfg_count, $cfg_count, $args[2], $args[3]);
            ++$cfg_count;
        }
    }
}

file_put_contents("haproxy.cfg", $cfg_haproxy);

?>