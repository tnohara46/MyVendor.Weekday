<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Package\Provide\Router\CliRouter($singleton('BEAR\\Sunday\\Extension\\Router\\RouterInterface-original', array('BEAR\\Package\\Provide\\Router\\CliRouter', '__construct', 'router')), null);
$instance->setStdIn('/private/var/folders/0r/lvwfww4x7md10p83zqm2nxtw0000gn/T/stdin-1241699773DfoYcA');
$isSingleton = false;
return $instance;
