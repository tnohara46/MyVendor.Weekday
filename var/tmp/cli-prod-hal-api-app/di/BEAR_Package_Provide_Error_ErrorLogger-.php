<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Package\Provide\Error\ErrorLogger($singleton('Psr\\Log\\LoggerInterface-', array('BEAR\\Package\\Provide\\Error\\ErrorLogger', '__construct', 'logger')), unserialize('O:17:"BEAR\\AppMeta\\Meta":4:{s:4:"name";s:16:"MyVendor\\Weekday";s:6:"appDir";s:30:"/Users/tatsuo/MyVendor.Weekday";s:6:"tmpDir";s:59:"/Users/tatsuo/MyVendor.Weekday/var/tmp/cli-prod-hal-api-app";s:6:"logDir";s:59:"/Users/tatsuo/MyVendor.Weekday/var/log/cli-prod-hal-api-app";}'));
$isSingleton = false;
return $instance;