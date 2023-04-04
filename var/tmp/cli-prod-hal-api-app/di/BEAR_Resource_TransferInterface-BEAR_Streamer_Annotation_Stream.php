<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\Streamer\StreamResponder($singleton('BEAR\\Streamer\\StreamerInterface-'));
$isSingleton = false;
return $instance;
