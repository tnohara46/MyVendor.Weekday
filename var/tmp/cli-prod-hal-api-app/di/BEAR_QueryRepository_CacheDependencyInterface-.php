<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\CacheDependency($singleton('BEAR\\QueryRepository\\UriTagInterface-'));
$isSingleton = false;
return $instance;
