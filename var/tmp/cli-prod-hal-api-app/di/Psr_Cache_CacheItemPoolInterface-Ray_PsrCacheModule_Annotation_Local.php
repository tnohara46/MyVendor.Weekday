<?php

namespace Ray\Di\Compiler;

$instance = new \Ray\PsrCacheModule\LocalCacheProvider('', '');
$isSingleton = true;
return $instance->get();
