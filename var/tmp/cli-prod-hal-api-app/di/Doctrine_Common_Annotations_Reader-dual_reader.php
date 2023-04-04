<?php

namespace Ray\Di\Compiler;

$instance = new \Koriym\Attributes\DualReader($prototype('Doctrine\\Common\\Annotations\\Reader-annotation_reader'), $prototype('Doctrine\\Common\\Annotations\\Reader-attribute_reader'));
$isSingleton = false;
return $instance;
