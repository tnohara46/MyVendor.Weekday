<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Package\Provide\Error\ErrorHandler($prototype('BEAR\\Sunday\\Extension\\Transfer\\TransferInterface-'), $prototype('BEAR\\Package\\Provide\\Error\\ErrorLogger-'), $prototype('BEAR\\Package\\Provide\\Error\\ErrorPageFactoryInterface-'));
$isSingleton = false;
return $instance;
