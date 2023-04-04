<?php

namespace Ray\Di\Compiler;

$instance = new \MyVendor\Weekday\Interceptor\BenchMarker($prototype('MyVendor\\Weekday\\MyLoggerInterface-'));
$isSingleton = true;
return $instance;
