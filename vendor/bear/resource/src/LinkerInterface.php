<?php

declare(strict_types=1);

namespace BEAR\Resource;

interface LinkerInterface
{
    /**
     * InvokerInterface link
     *
     * @return ResourceObject
     */
    public function invoke(AbstractRequest $request);
}
