<?php

namespace Ray\Di\Compiler;

$instance = new \Koriym\ParamReader\ParamReader($singleton('Doctrine\\Common\\Annotations\\Reader-'));
$isSingleton = false;
return $instance;
