<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Streamer\StreamProvider();
$isSingleton = true;
return $instance->get();
