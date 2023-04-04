<?php

declare (strict_types=1);
namespace MyVendor\Weekday\Resource\Page;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceObject;
class Index_1121465652 extends \MyVendor\Weekday\Resource\Page\Index implements \Ray\Aop\WeavedInterface
{
    use \Ray\Aop\InterceptTrait;
    
    /**
     * @Embed(rel="weekday", src="app://self/weekday{?year,month,day}")
     */
    public function onGet(int $year, int $month, int $day) : \BEAR\Resource\ResourceObject
    {
        return $this->_intercept(func_get_args(), __FUNCTION__);
    }
}
