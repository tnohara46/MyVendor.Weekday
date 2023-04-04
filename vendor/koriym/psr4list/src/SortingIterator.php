<?php

declare(strict_types=1);

/**
 * This file is part of the Koriym.Psr4List
 */

namespace Koriym\Psr4List;

use ArrayIterator;
use IteratorAggregate;
use RegexIterator;
use SplFileInfo;

use function count;
use function explode;
use function iterator_to_array;
use function usort;

/**
 * @template-implements IteratorAggregate<SplFileInfo>
 */
class SortingIterator implements IteratorAggregate
{
    /** @var ArrayIterator<int, SplFileInfo> */
    private $iterator;

    public function __construct(RegexIterator $iterator)
    {
        /** @var array{0: SplFileInfo, 1: SplFileInfo} $array */
        $array = iterator_to_array($iterator);
        usort(
            $array,
            /**
             * @return int
             */
            static function (SplFileInfo $a, SplFileInfo $b) {
                $pathA = $a->getPathname();
                $pathB = $b->getPathname();
                $cntA = count(explode('/', $pathA));
                $cntB = count(explode('/', $pathB));
                if ($cntA !== $cntB) {
                    return $cntA > $cntB ? 1 : -1;
                }

                return $a->getPathname() > $b->getPathname() ? 1 : -1;
            }
        );
        /** @var array<int, SplFileInfo> $array */
        $this->iterator = new ArrayIterator($array);
    }

    /**
     * @return ArrayIterator<int, SplFileInfo>
     */
    public function getIterator(): ArrayIterator
    {
        return $this->iterator;
    }
}
