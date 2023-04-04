<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Streamer\StreamRenderer($prototype('BEAR\\Resource\\RenderInterface-'), $singleton('BEAR\\Streamer\\StreamerInterface-'));
$isSingleton = false;
return $instance;
