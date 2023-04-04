<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Resource\OptionsMethods($singleton('Doctrine\\Common\\Annotations\\Reader-'), '');
$isSingleton = false;
return $instance;
