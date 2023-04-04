<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Resource\Invoker($singleton('BEAR\\Resource\\NamedParameterInterface-'), $prototype('BEAR\\Resource\\ExtraMethodInvoker-'), $prototype('BEAR\\Resource\\LoggerInterface-'));
$isSingleton = false;
return $instance;
