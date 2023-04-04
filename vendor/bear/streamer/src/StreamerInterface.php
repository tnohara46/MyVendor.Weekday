<?php

declare(strict_types=1);

namespace BEAR\Streamer;

interface StreamerInterface
{
    /**
     * @param resource[] $streams
     */
    public function addStreams(array $streams): void;

    /**
     * Return single root stream
     *
     * @return resource
     */
    public function getStream(string $string);
}
