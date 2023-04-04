<?php

namespace Ray\Di\Compiler;

$instance = new \MyVendor\Weekday\Resource\App\Weekday_3622728082($prototype('MyVendor\\Weekday\\MyLoggerInterface-'));
$instance->bindings = array('onGet' => array($singleton('MyVendor\\Weekday\\Interceptor\\BenchMarker-')));
$instance->setRenderer($prototype('BEAR\\Resource\\RenderInterface-'));
$isSingleton = false;
return $instance;
