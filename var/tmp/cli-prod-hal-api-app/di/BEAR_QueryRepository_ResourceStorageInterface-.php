<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\ResourceStorage($singleton('BEAR\\QueryRepository\\RepositoryLoggerInterface-'), $prototype('BEAR\\QueryRepository\\PurgerInterface-'), $singleton('BEAR\\QueryRepository\\UriTagInterface-'), $singleton('Psr\\Cache\\CacheItemPoolInterface-Ray\\PsrCacheModule\\Annotation\\Shared', array('BEAR\\QueryRepository\\ResourceStorage', '__construct', 'pool')), null, null, 0.15);
$instance->setInjector($injector());
$isSingleton = false;
return $instance;
