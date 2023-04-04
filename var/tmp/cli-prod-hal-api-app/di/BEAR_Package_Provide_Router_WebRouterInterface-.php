<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Package\Provide\Router\WebRouter('app://self', $prototype('BEAR\\Package\\Provide\\Router\\HttpMethodParamsInterface-'));
$isSingleton = false;
return $instance;
