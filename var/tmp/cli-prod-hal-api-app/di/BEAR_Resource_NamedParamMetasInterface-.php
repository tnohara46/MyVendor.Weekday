<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Resource\NamedParamMetas($singleton('Doctrine\\Common\\Annotations\\Reader-'));
$isSingleton = false;
return $instance;
