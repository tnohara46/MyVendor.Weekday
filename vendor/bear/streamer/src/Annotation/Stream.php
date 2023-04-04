<?php

declare(strict_types=1);

namespace BEAR\Streamer\Annotation;

use Attribute;
use Ray\Di\Di\Qualifier;
use function is_string;
use function var_dump;

/**
 * @Annotation
 * @Target("METHOD")
 * @Qualifier
 */
#[Attribute(Attribute::TARGET_METHOD), Qualifier]
final class Stream
{
}
