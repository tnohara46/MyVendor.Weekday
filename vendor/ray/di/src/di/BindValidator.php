<?php

declare(strict_types=1);

namespace Ray\Di;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\NullInterceptor;
use Ray\Di\Exception\InvalidProvider;
use Ray\Di\Exception\InvalidType;
use Ray\Di\Exception\NotFound;
use ReflectionClass;

use function class_exists;
use function interface_exists;

final class BindValidator
{
    public function constructor(string $interface): void
    {
        if ($interface && ! interface_exists($interface) && ! class_exists($interface)) {
            throw new NotFound($interface);
        }
    }

    /**
     * To validator
     *
     * @param class-string<T> $class
     *
     * @return ReflectionClass<T>
     *
     * @template T of object
     */
    public function to(string $interface, string $class): ReflectionClass
    {
        if (! class_exists($class)) {
            throw new NotFound($class);
        }

        if (! $this->isNullInterceptorBinding($class, $interface) && interface_exists($interface) && ! (new ReflectionClass($class))->implementsInterface($interface)) {
            throw new InvalidType("[{$class}] is no implemented [{$interface}] interface");
        }

        return new ReflectionClass($class);
    }

    /**
     * toProvider validator
     *
     * @phpstan-param class-string $provider
     *
     * @return ReflectionClass<object>
     *
     * @throws NotFound
     */
    public function toProvider(string $provider): ReflectionClass
    {
        if (! class_exists($provider)) {
            /** @psalm-suppress MixedArgument -- should be string */
            throw new NotFound($provider);
        }

        if (! (new ReflectionClass($provider))->implementsInterface(ProviderInterface::class)) {
            throw new InvalidProvider($provider);
        }

        return new ReflectionClass($provider);
    }

    private function isNullInterceptorBinding(string $class, string $interface): bool
    {
        return $class === NullInterceptor::class && interface_exists($interface) && (new ReflectionClass($interface))->implementsInterface(MethodInterceptor::class);
    }
}
