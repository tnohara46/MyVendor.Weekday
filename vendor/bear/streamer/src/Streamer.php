<?php

declare(strict_types=1);

namespace BEAR\Streamer;

use BEAR\Streamer\Annotation\Stream;

use function array_keys;
use function array_shift;
use function fwrite;
use function implode;
use function preg_match_all;
use function preg_split;
use function rewind;
use function sprintf;
use function stream_copy_to_stream;

use const PREG_SET_ORDER;

final class Streamer implements StreamerInterface
{
    /** @var resource */
    private $stream;

    /** @var array<resource> */
    private $streams = [];

    /**
     * @param resource $stream
     *
     * @Stream
     */
    #[Stream]
    public function __construct($stream)
    {
        $this->stream = $stream;
    }

    /**
     * @param resource[] $streams
     */
    public function addStreams(array $streams): void
    {
        $this->streams += $streams;
    }

    /**
     * Return single root stream
     *
     * @return resource
     */
    public function getStream(string $string)
    {
        $stream = $this->stream;
        rewind($stream);
        $hash = array_keys($this->streams);
        $regex = sprintf('/(%s)/', implode('|', $hash));
        preg_match_all($regex, $string, $match, PREG_SET_ORDER);
        /** @var array<int, string> $match */
        $list = $this->collect($match);
        $bodies = (array) preg_split($regex, $string);
        foreach ($bodies as $body) {
            fwrite($stream, (string) $body);
            $index = array_shift($list);
            if (isset($this->streams[$index])) {
                $popStream = $this->streams[$index];
                rewind($popStream);
                stream_copy_to_stream($popStream, $stream);
            }
        }

        return $stream;
    }

    /**
     * @param array<int, string> $match
     *
     * @return array<int, string>
     */
    private function collect(array $match): array
    {
        $list = [];
        foreach ($match as $item) {
            $list[] = $item[0];
        }

        return $list;
    }
}
