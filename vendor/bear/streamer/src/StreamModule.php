<?php

declare(strict_types=1);

namespace BEAR\Streamer;

use BEAR\Resource\RenderInterface;
use BEAR\Resource\TransferInterface;
use BEAR\Streamer\Annotation\Stream;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class StreamModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->bind(RenderInterface::class)->annotatedWith(Stream::class)->to(StreamRenderer::class);
        $this->bind()->annotatedWith(Stream::class)->toProvider(StreamProvider::class)->in(Scope::SINGLETON);
        $this->bind(StreamerInterface::class)->to(Streamer::class)->in(Scope::SINGLETON);
        $this->bind(TransferInterface::class)->annotatedWith(Stream::class)->to(StreamResponder::class);
    }
}
