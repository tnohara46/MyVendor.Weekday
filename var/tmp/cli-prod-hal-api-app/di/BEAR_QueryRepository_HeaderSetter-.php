<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\HeaderSetter($singleton('BEAR\\QueryRepository\\EtagSetterInterface-'));
$isSingleton = false;
return $instance;
