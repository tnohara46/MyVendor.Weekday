<?php

declare(strict_types=1);

namespace MyVendor\Weekday\Interceptor;

use MyVendor\Weekday\MyLoggerInterface;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

use function microtime;
use function sprintf;

class BenchMarker implements MethodInterceptor
{
    public function __construct(private MyLoggerInterface $logger)
    {
    }

    public function invoke(MethodInvocation $invocation)
    {
        $start = microtime(true);
        $result = $invocation->proceed(); // 元のメソッドの実行
        $time = microtime(true) - $start;
        $message = sprintf('%s: %0.5f(µs)', $invocation->getMethod()->getName(), $time);
        $this->logger->log($message);

        return $result;
    }
}