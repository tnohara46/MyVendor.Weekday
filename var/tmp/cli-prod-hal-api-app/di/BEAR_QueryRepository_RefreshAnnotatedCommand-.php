<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\RefreshAnnotatedCommand($singleton('BEAR\\QueryRepository\\QueryRepositoryInterface-'), $singleton('BEAR\\Resource\\ResourceInterface-'));
$isSingleton = false;
return $instance;
