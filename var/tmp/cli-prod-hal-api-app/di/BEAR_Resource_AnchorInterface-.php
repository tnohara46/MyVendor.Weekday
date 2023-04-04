<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Resource\Anchor($singleton('Doctrine\\Common\\Annotations\\Reader-'));
$isSingleton = false;
return $instance;
