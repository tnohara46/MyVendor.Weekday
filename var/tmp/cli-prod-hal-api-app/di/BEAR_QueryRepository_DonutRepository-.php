<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\DonutRepository($singleton('BEAR\\QueryRepository\\QueryRepositoryInterface-'), $prototype('BEAR\\QueryRepository\\HeaderSetter-'), $prototype('BEAR\\QueryRepository\\ResourceStorageInterface-'), $singleton('BEAR\\Resource\\ResourceInterface-'), $prototype('BEAR\\QueryRepository\\CdnCacheControlHeaderSetterInterface-'), $singleton('BEAR\\QueryRepository\\RepositoryLoggerInterface-'), $prototype('BEAR\\QueryRepository\\DonutRendererInterface-'));
$isSingleton = true;
return $instance;
