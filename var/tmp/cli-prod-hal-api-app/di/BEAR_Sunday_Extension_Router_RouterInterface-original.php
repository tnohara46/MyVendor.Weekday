<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Package\Provide\Router\RouterCollectionProvider($prototype('BEAR\\Sunday\\Extension\\Router\\RouterInterface-primary_router'), $prototype('BEAR\\Package\\Provide\\Router\\WebRouterInterface-'));
$isSingleton = true;
return $instance->get();
