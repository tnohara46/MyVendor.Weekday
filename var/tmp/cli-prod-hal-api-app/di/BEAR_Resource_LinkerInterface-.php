<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Resource\Linker($singleton('Doctrine\\Common\\Annotations\\Reader-'), $prototype('BEAR\\Resource\\InvokerInterface-'), $prototype('BEAR\\Resource\\FactoryInterface-'));
$isSingleton = false;
return $instance;
