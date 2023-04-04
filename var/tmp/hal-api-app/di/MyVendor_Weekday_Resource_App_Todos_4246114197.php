<?php

namespace MyVendor\Weekday\Resource\App;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\ResourceObject;
use Ray\CakeDbModule\Annotation\Transactional;
use Ray\CakeDbModule\DatabaseInject;
/**
 * @Cacheable
 */
class Todos_4246114197 extends \MyVendor\Weekday\Resource\App\Todos implements \Ray\Aop\WeavedInterface
{
    use \Ray\Aop\InterceptTrait;
    
    public function onGet(int $id) : \BEAR\Resource\ResourceObject
    {
        return $this->_intercept(func_get_args(), __FUNCTION__);
    }
    
    /**
     * @Transactional
     * @ReturnCreatedResource
     */
    public function onPost(string $todo) : \BEAR\Resource\ResourceObject
    {
        return $this->_intercept(func_get_args(), __FUNCTION__);
    }
    
    /**
     * @Transactional
     */
    public function onPut(int $id, string $todo) : \BEAR\Resource\ResourceObject
    {
        return $this->_intercept(func_get_args(), __FUNCTION__);
    }
}
