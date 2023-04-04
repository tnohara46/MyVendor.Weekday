<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Resource\Module\SchemeCollectionProvider('MyVendor\\Weekday', $injector());
$isSingleton = false;
return $instance->get();
