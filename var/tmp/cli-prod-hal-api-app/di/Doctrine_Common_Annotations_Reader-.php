<?php

namespace Ray\Di\Compiler;

$instance = new \Doctrine\Common\Annotations\PsrCachedReader($prototype('Doctrine\\Common\\Annotations\\Reader-dual_reader'), $singleton('Psr\\Cache\\CacheItemPoolInterface-Ray\\PsrCacheModule\\Annotation\\Local', array('Doctrine\\Common\\Annotations\\PsrCachedReader', '__construct', 'cache')), false);
$isSingleton = true;
return $instance;
