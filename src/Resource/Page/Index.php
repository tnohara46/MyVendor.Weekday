<?php

declare(strict_types=1);
/*
namespace MyVendor\Weekday\Resource\Page;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    /** @var array{greeting: string} */
    /*
    public $body;

    /** @return static */
    /*
    public function onGet(string $name = 'BEAR.Sunday'): static
    {
        $this->body = [
            'greeting' => 'Hello ' . $name,
        ];

        return $this;
    }
}
*/
?>
<?php
namespace MyVendor\Weekday\Resource\Page;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    /**
     * @Embed(rel="weekday", src="app://self/weekday{?year,month,day}")
     */
    public function onGet(int $year, int $month, int $day) : ResourceObject
    {
        $this->body += [
            'year' => $year,
            'month' => $month,
            'day' => $day
        ];

        return $this;
    }
}