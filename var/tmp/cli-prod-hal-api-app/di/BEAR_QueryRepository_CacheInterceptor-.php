<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\CacheInterceptor($singleton('BEAR\\QueryRepository\\QueryRepositoryInterface-'));
$isSingleton = true;
return $instance;
