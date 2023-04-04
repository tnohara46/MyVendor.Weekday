<?php

declare(strict_types=1);

/**
 * This file is part of the Koriym.Psr4List
 */

namespace Koriym\Psr4List;

use FilesystemIterator;
use Generator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

use function class_exists;
use function interface_exists;
use function str_replace;
use function strlen;
use function substr;

class Psr4List
{
    /**
     * @param string $prefix
     * @param string $path
     *
     * @return Generator<array{0: class-string, 1: string}>
     */
    public function __invoke($prefix, $path): Generator
    {
        return $this->invoke($prefix, $path);
    }

    /**
     * @param string $prefix
     * @param string $path
     *
     * @return Generator<array{0: string, 1: string}>
     */
    private function invoke($prefix, $path): Generator
    {
        foreach ($this->files($path) as $item) {
            $file = $item->getPathname();
            $namePath = str_replace('/', '\\', substr(substr($file, strlen($path) + 1), 0, -4));
            $class = $prefix . '\\' . $namePath;
            if (! class_exists($class) && ! interface_exists($class)) {
                continue;
            }

            yield [$class, $file];
        }
    }

    /**
     * @param string $dir
     */
    private function files($dir): SortingIterator
    {
        return new SortingIterator(
            new RegexIterator(
                new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator(
                        $dir,
                        FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::SKIP_DOTS
                    ),
                    RecursiveIteratorIterator::LEAVES_ONLY
                ),
                '/^.+\.php$/',
                RecursiveRegexIterator::MATCH
            )
        );
    }
}
