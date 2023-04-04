<?php

declare(strict_types=1);

namespace BEAR\Resource;

use BEAR\Resource\Exception\JsonSchemaException;

class JsonSchemaExceptionNullHandler implements JsonSchemaExceptionHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle(ResourceObject $ro, JsonSchemaException $e, string $schemaFile)
    {
        throw $e;
    }
}
