<?php

namespace Ray\Di\Compiler;

$instance = new \MyVendor\Weekday\Resource\Page\Index_3079055325();
$instance->bindings = array('onGet' => array($singleton('BEAR\\Resource\\EmbedInterceptor-')));
$instance->setRenderer($prototype('BEAR\\Resource\\RenderInterface-'));
$isSingleton = false;
return $instance;
