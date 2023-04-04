<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\DonutCacheInterceptor($singleton('BEAR\\QueryRepository\\DonutRepositoryInterface-'));
$isSingleton = true;
return $instance;
