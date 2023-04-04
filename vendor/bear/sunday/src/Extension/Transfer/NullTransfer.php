<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Transfer;

use BEAR\Resource\ResourceObject;

final class NullTransfer implements TransferInterface
{
    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function __invoke(ResourceObject $ro, array $server): void
    {
    }
}
