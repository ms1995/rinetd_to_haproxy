# rinetd_to_haproxy
A very simple configuration converter for RINETD users to switch to HAProxy.

Put `rinetd.conf` into the same directory with `cnv.php`, then run:

```bash
php cnv.php
```

And you will have the new `haproxy.cfg`. You might still need to fine tune the configuration file.