<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Package\Provide\Router\AuraRouter($singleton('Aura\\Router\\RouterContainer-', array('BEAR\\Package\\Provide\\Router\\AuraRouter', '__construct', 'routerContainer')), $prototype('BEAR\\Package\\Provide\\Router\\HttpMethodParamsInterface-'), 'app://self', null);
$isSingleton = false;
return $instance;
