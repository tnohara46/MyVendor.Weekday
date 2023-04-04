<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\CliHttpCache($prototype('BEAR\\QueryRepository\\ResourceStorageInterface-'));
$isSingleton = false;
return $instance;
