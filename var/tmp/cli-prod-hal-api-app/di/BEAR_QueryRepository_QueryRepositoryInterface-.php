<?php

namespace Ray\Di\Compiler;

$instance = new \BEAR\QueryRepository\QueryRepository($singleton('BEAR\\QueryRepository\\RepositoryLoggerInterface-'), $prototype('BEAR\\QueryRepository\\HeaderSetter-'), $prototype('BEAR\\QueryRepository\\ResourceStorageInterface-'), $singleton('Doctrine\\Common\\Annotations\\Reader-'), unserialize('O:27:"BEAR\\QueryRepository\\Expiry":1:{s:33:" BEAR\\QueryRepository\\Expiry time";a:4:{s:5:"short";i:60;s:6:"medium";i:3600;s:4:"long";i:86400;s:5:"never";i:31536000;}}'));
$isSingleton = true;
return $instance;
