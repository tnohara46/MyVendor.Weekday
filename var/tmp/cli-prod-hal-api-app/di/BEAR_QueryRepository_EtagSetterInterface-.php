<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\EtagSetter($prototype('BEAR\\QueryRepository\\CacheDependencyInterface-'));
$isSingleton = true;
return $instance;
