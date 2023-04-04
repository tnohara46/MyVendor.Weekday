<?php

namespace Ray\Di\Compiler;

$instance = new \Ray\PsrCacheModule\LocalCacheProvider('', '');
$isSingleton = false;
return $instance->get();
