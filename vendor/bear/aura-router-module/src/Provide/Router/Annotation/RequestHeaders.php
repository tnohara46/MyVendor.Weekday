<?php

declare(strict_types=1);

namespace BEAR\Package\Provide\Router\Annotation;

use Attribute;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;
use Ray\Di\Di\Qualifier;

/**
 * @Annotation
 * @Target("METHOD")
 * @Qualifier
 * @NamedArgumentConstructor
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_PARAMETER), Qualifier]
final class RequestHeaders
{
    /** @var ?string */
    public $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}
