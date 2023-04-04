<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\DonutCacheableResponseInterceptor($singleton('BEAR\\QueryRepository\\DonutRepositoryInterface-'));
$isSingleton = true;
return $instance;
