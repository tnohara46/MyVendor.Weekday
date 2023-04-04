<?php

declare (strict_types=1);
namespace BEAR\Package\Provide\Error;

use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\NullRenderer;
use BEAR\Resource\RenderInterface;
use BEAR\Resource\ResourceObject;
use Ray\Di\Di\Inject;
#[\BEAR\RepositoryModule\Annotation\Cacheable]
class NullPage_48028825 extends \BEAR\Package\Provide\Error\NullPage implements \Ray\Aop\WeavedInterface
{
    use \Ray\Aop\InterceptTrait;
    
    public function onGet(string $required, int $optional = 0) : \BEAR\Resource\ResourceObject
    {
        return $this->_intercept(func_get_args(), __FUNCTION__);
    }
}
