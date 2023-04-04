<?php

declare(strict_types=1);

namespace BEAR\Streamer;

use BEAR\Resource\RenderInterface;
use BEAR\Resource\TransferInterface;
use BEAR\Streamer\Annotation\Stream;
use Ray\Di\Di\Inject;

trait StreamTransferInject
{
    /** @var TransferInterface */
    private $responder;

    /**
     * @return static
     *
     * @Inject
     * @Stream
     */
    #[Inject, Stream]
    public function setRenderer(RenderInterface $render)
    {
        return parent::setRenderer($render);
    }

    /**
     * @Inject
     * @Stream
     */
    #[Inject, Stream]
    public function setTransfer(TransferInterface $responder): void
    {
        $this->responder = $responder;
    }

    /**
     * {@inheritdoc}
     */
    public function transfer(TransferInterface $responder, array $server): void
    {
        unset($responder);
        parent::transfer($this->responder, $server);
    }
}
