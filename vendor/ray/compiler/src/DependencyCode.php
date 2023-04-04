<?php

declare(strict_types=1);

namespace Ray\Compiler;

use DomainException;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt;
use Ray\Di\Argument;
use Ray\Di\Arguments;
use Ray\Di\Container;
use Ray\Di\Dependency;
use Ray\Di\DependencyInterface;
use Ray\Di\DependencyProvider;
use Ray\Di\Instance;
use Ray\Di\NewInstance;
use Ray\Di\SetContextInterface;
use Ray\Di\SetterMethod;
use Ray\Di\SetterMethods;

use function get_class;
use function is_a;

final class DependencyCode implements SetContextInterface
{
    /** @var BuilderFactory */
    private $factory;

    /** @var Normalizer */
    private $normalizer;

    /** @var FactoryCode */
    private $factoryCompiler;

    /** @var PrivateProperty */
    private $privateProperty;

    /** @var IpQualifier|null */
    private $qualifier;

    /**
     * @var string
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $context;

    /** @var AopCode */
    private $aopCode;

    public function __construct(Container $container, ?ScriptInjector $injector = null)
    {
        $this->factory = new BuilderFactory();
        $this->normalizer = new Normalizer();
        $this->factoryCompiler = new FactoryCode($container, new Normalizer(), $this, $injector);
        $this->privateProperty = new PrivateProperty();
        $this->aopCode = new AopCode($this->privateProperty);
    }

    /**
     * Return compiled dependency code
     */
    public function getCode(DependencyInterface $dependency): Code
    {
        if ($dependency instanceof Dependency) {
            return $this->getDependencyCode($dependency);
        }

        if ($dependency instanceof Instance) {
            return $this->getInstanceCode($dependency);
        }

        if ($dependency instanceof DependencyProvider) {
            return $this->getProviderCode($dependency);
        }

        throw new DomainException(get_class($dependency));
    }

    /**
     * {@inheritdoc}
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    public function setQaulifier(IpQualifier $qualifer): void
    {
        $this->qualifier = $qualifer;
    }

    public function getIsSingletonCode(bool $isSingleton): Expr\Assign
    {
        $bool = new Expr\ConstFetch(new Node\Name([$isSingleton ? 'true' : 'false']));

        return new Expr\Assign(new Expr\Variable('isSingleton'), $bool);
    }

    /**
     * Compile DependencyInstance
     */
    private function getInstanceCode(Instance $instance): Code
    {
        $node = ($this->normalizer)($instance->value);

        return new Code(new Node\Stmt\Return_($node), false);
    }

    /**
     * Compile generic object dependency
     */
    private function getDependencyCode(Dependency $dependency): Code
    {
        $prop = $this->privateProperty;
        $node = $this->getFactoryNode($dependency);
        ($this->aopCode)($dependency, $node);
        /** @var bool $isSingleton */
        $isSingleton = $prop($dependency, 'isSingleton');
        $node[] = $this->getIsSingletonCode($isSingleton);
        $node[] = new Node\Stmt\Return_(new Node\Expr\Variable('instance'));
        $namespace = $this->factory->namespace('Ray\Di\Compiler')->addStmts($node)->getNode();
        $qualifer = $this->qualifier;
        $this->qualifier = null;

        return new Code($namespace, $isSingleton, $qualifer);
    }

    /**
     * Compile dependency provider
     */
    private function getProviderCode(DependencyProvider $provider): Code
    {
        $prop = $this->privateProperty;
        /** @var DependencyInterface $dependency */
        $dependency = $prop($provider, 'dependency');
        $node = $this->getFactoryNode($dependency);
        $provider->setContext($this);
        /** @var NewInstance $class */
        $class = $prop($dependency, 'newInstance');
        $classString = (string) $class;
        if (is_a($classString, SetContextInterface::class, true)) {
            $node[] = $this->getSetContextCode($this->context); // $instance->setContext($this->context);
        }

        /** @var bool $isSingleton */
        $isSingleton = $prop($provider, 'isSingleton');
        $node[] = $this->getIsSingletonCode($isSingleton);
        $node[] = new Stmt\Return_(new MethodCall(new Expr\Variable('instance'), 'get'));
        $node = $this->factory->namespace('Ray\Di\Compiler')->addStmts($node)->getNode();
        $qualifer = $this->qualifier;
        $this->qualifier = null;

        return new Code($node, $isSingleton, $qualifer);
    }

    private function getSetContextCode(string $context): MethodCall
    {
        $arg = new Node\Arg(new Node\Scalar\String_($context));

        return new MethodCall(new Expr\Variable('instance'), 'setContext', [$arg]);
    }

    /**
     * Return generic factory code
     *
     * This code is used by Dependency and DependencyProvider
     *
     * @return array<Expr>
     */
    private function getFactoryNode(DependencyInterface $dependency): array
    {
        $prop = $this->privateProperty;
        /** @var NewInstance $newInstance */
        $newInstance = $prop($dependency, 'newInstance');
        // class name
        /** @var class-string $class */
        $class = $prop($newInstance, 'class');
        /** @var SetterMethods $setterMethodsObject */
        $setterMethodsObject = $prop($newInstance, 'setterMethods');
        /** @var array<SetterMethod> $setterMethods */
        $setterMethods = (array) $prop($setterMethodsObject, 'setterMethods');
        /** @var Arguments $argumentsObject */
        $argumentsObject = $prop($newInstance, 'arguments');
        /** @var array<Argument> $arguments */
        $arguments = (array) $prop($argumentsObject, 'arguments');
        /** @var ?string $postConstruct */
        $postConstruct = $prop($dependency, 'postConstruct');

        return $this->factoryCompiler->getFactoryCode($class, $arguments, $setterMethods, (string) $postConstruct);
    }
}
