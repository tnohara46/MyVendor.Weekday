<?php

declare(strict_types=1);

namespace Ray\Di;

use Doctrine\Common\Annotations\Reader;
use Ray\Di\Di\Qualifier;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use Serializable;

use function assert;
use function class_exists;
use function serialize;
use function unserialize;

final class InjectionPoint implements InjectionPointInterface, Serializable
{
    /** @var ?ReflectionParameter */
    private $parameter;

    /** @var Reader */
    private $reader;

    /** @var string */
    private $pClass;

    /** @var string */
    private $pFunction;

    /** @var string */
    private $pName;

    public function __construct(ReflectionParameter $parameter, Reader $reader)
    {
        $this->parameter = $parameter;
        $this->pFunction = (string) $parameter->getDeclaringFunction()->name;
        $class = $parameter->getDeclaringClass();
        $this->pClass = $class instanceof ReflectionClass ? $class->name : '';
        $this->pName = $parameter->name;
        $this->reader = $reader;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter(): ReflectionParameter
    {
        return $this->parameter ?? new ReflectionParameter([$this->pClass, $this->pFunction], $this->pName);
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod(): ReflectionMethod
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
        $this->parameter = $this->getParameter();
        $class = $this->parameter->getDeclaringClass();
        assert($class instanceof ReflectionClass);

        return $class;
    }

    /**
     * {@inheritdoc}
     */
    public function getQualifiers(): array
    {
        $qualifiers = [];
        $annotations = $this->reader->getMethodAnnotations($this->getMethod());
        foreach ($annotations as $annotation) {
            $qualifier = $this->reader->getClassAnnotation(
                new ReflectionClass($annotation),
                Qualifier::class
            );
            if ($qualifier instanceof Qualifier) {
                $qualifiers[] = $annotation;
            }
        }

        return $qualifiers;
    }

    /**
     * @return array{0: Reader, 1: string, 2: string, 3: string}
     */
    public function __serialize(): array
    {
        return [$this->reader, $this->pClass, $this->pFunction, $this->pName];
    }

    /**
     * {@inheritDoc}
     *
     * @param array{0: Reader, 1: string, 2: string, 3: string} $array
     */
    public function __unserialize(array $array): void
    {
        [$this->reader, $this->pClass, $this->pFunction, $this->pName] = $array;
    }

    public function serialize(): ?string
    {
        return serialize($this->__serialize());
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-param string $data
     */
    public function unserialize($data): void
    {
        /** @var array{0: Reader, 1: string, 2: string, 3: string} $array */
        $array = unserialize($data, ['allowed_classes' => [Reader::class]]);
        $this->__unserialize($array);
    }
}
