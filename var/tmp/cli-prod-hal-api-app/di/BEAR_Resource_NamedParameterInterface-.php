<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Resource\NamedParameter($prototype('BEAR\\Resource\\NamedParamMetasInterface-'), $injector());
$isSingleton = true;
return $instance;
