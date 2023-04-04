<?php

namespace Ray\Di\Compiler;

$instance = new \MyVendor\Weekday\Module\App($prototype('BEAR\\Sunday\\Extension\\Transfer\\HttpCacheInterface-'), $prototype('BEAR\\Sunday\\Extension\\Router\\RouterInterface-'), $prototype('BEAR\\Sunday\\Extension\\Transfer\\TransferInterface-'), $singleton('BEAR\\Resource\\ResourceInterface-'), $prototype('BEAR\\Sunday\\Extension\\Error\\ThrowableHandlerInterface-'));
$isSingleton = true;
return $instance;
