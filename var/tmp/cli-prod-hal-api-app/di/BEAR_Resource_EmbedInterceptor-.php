<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Resource\EmbedInterceptor($singleton('BEAR\\Resource\\ResourceInterface-'), $singleton('Doctrine\\Common\\Annotations\\Reader-'));
$isSingleton = true;
return $instance;
