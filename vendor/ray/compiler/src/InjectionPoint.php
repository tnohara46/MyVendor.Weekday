<?php

declare(strict_types=1);

namespace Ray\Compiler;

use Ray\Aop\ReflectionMethod;
use Ray\Di\InjectionPointInterface;
use ReflectionClass;
use ReflectionParameter;
use RuntimeException;

use function assert;
use function class_exists;
use function file_exists;
use function file_get_contents;
use function is_bool;
use function sprintf;
use function str_replace;
use function unserialize;

final class InjectionPoint implements InjectionPointInterface
{
    /** @var ReflectionParameter */
    private $parameter;

    /** @var string */
    private $scriptDir;

    public function __construct(ReflectionParameter $parameter, string $scriptDir)
    {
        $this->parameter = $parameter;
        $this->scriptDir = $scriptDir;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter(): ReflectionParameter
    {
        return $this->parameter;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod(): \ReflectionMethod
    {
        $this->parameter = $this->getParameter();
        $class = $this->parameter->getDeclaringClass();
        assert($class instanceof ReflectionClass);
        $method = $this->parameter->getDeclaringFunction()->getShortName();
        assert(class_exists($class->name));

        return new ReflectionMethod($class->name, $method);
    }

    /**
     * {@inheritdoc}
     */
    public function getClass(): ReflectionClass
    {
        $class = $this->parameter->getDeclaringClass();
        assert($class instanceof ReflectionClass);

        return $class;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<(object|null)>
     *
     * @psalm-suppress ImplementedReturnTypeMismatch
     */
    public function getQualifiers(): array
    {
        return [$this->getQualifier()];
    }

    /**
     * {@inheritdoc}
     *
     * @return object|null
     */
    public function getQualifier()
    {
        $class = $this->parameter->getDeclaringClass();
        assert($class instanceof ReflectionClass);

        $qualifierFile = sprintf(
            ScriptInjector::QUALIFIER,
            $this->scriptDir,
            str_replace('\\', '_', $class->name),
            $this->parameter->getDeclaringFunction()->name,
            $this->parameter->name
        );
        // @codeCoverageIgnoreStart
        if (! file_exists($qualifierFile)) {
            return null;
        }

        // @codeCoverageIgnoreEnd

        $qualifierString = file_get_contents($qualifierFile);
        if (is_bool($qualifierString)) {
            throw new RuntimeException(); // @codeCoverageIgnore
        }

        /** @var ?object $qualifier */
        $qualifier = unserialize($qualifierString, ['allowed_classes' => true]);

        return $qualifier;
    }
}
