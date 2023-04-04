<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Resource\HalRenderer($singleton('Doctrine\\Common\\Annotations\\Reader-'), $prototype('BEAR\\Resource\\HalLink-'));
$isSingleton = false;
return $instance;
