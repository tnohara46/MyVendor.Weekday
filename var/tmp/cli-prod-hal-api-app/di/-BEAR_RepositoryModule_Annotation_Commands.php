<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\CommandsProvider($singleton('BEAR\\QueryRepository\\QueryRepositoryInterface-'), $singleton('BEAR\\Resource\\ResourceInterface-'));
$isSingleton = false;
return $instance->get();
