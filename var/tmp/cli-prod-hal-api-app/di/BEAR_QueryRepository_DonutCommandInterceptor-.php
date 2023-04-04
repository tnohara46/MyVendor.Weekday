<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\DonutCommandInterceptor($singleton('BEAR\\QueryRepository\\DonutRepositoryInterface-'), $singleton('BEAR\\QueryRepository\\MatchQueryInterface-'));
$isSingleton = true;
return $instance;
