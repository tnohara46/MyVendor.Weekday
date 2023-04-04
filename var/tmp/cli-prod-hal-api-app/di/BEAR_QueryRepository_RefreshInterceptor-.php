<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\RefreshInterceptor($prototype('BEAR\\QueryRepository\\RefreshAnnotatedCommand-'));
$isSingleton = true;
return $instance;
