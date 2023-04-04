<?php

declare (strict_types=1);
namespace MyVendor\Weekday\Resource\App;

use BEAR\Resource\ResourceObject;
use DateTimeImmutable;
use MyVendor\Weekday\Exception\InvalidDateTime;
use MyVendor\Weekday\MyLoggerInterface;
use MyVendor\Weekday\Annotation\BenchMark;
class Weekday_1645938220 extends \MyVendor\Weekday\Resource\App\Weekday implements \Ray\Aop\WeavedInterface
{
    use \Ray\Aop\InterceptTrait;
    
    #[\MyVendor\Weekday\Annotation\BenchMark]
    public function onGet(int $year, int $month, int $day) : static
    {
        return $this->_intercept(func_get_args(), __FUNCTION__);
    }
}
