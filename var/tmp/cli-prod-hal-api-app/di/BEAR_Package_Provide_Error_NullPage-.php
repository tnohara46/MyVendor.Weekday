<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Package\Provide\Error\NullPage_48028825();
$instance->bindings = array('onGet' => array($singleton('BEAR\\QueryRepository\\CacheInterceptor-'), $singleton('BEAR\\QueryRepository\\CacheInterceptor-')));
$instance->setRenderer($prototype('BEAR\\Resource\\RenderInterface-'));
$isSingleton = false;
return $instance;
