<?php

declare(strict_types=1);

namespace BEAR\Resource;

use BEAR\Resource\Annotation\Link;
use BEAR\Resource\Exception\LinkQueryException;
use BEAR\Resource\Exception\LinkRelException;
use BEAR\Resource\Exception\MethodException;
use BEAR\Resource\Exception\UriException;
use Doctrine\Common\Annotations\Reader;
use ReflectionMethod;

use function array_filter;
use function array_key_exists;
use function array_keys;
use function array_pop;
use function assert;
use function count;
use function is_array;
use function ucfirst;
use function uri_template;

/** @SuppressWarnings(PHPMD.CouplingBetweenObjects) */
final class Linker implements LinkerInterface
{
    /**
     * memory cache for linker
     *
     * @var array<string, mixed>
     */
    private array $cache = [];

    public function __construct(
        private Reader $reader,
        private InvokerInterface $invoker,
        private FactoryInterface $factory,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function invoke(AbstractRequest $request)
    {
        $this->cache = [];

        return $this->invokeRecursive($request);
    }

    /**
     * @throws LinkQueryException
     * @throws LinkRelException
     */
    private function invokeRecursive(AbstractRequest $request): ResourceObject
    {
        $this->invoker->invoke($request);
        $current = clone $request->resourceObject;
        if ($current->code >= Code::BAD_REQUEST) {
            return $current;
        }

        foreach ($request->links as $link) {
            /** @var array<mixed> $nextBody */
            $nextBody = $this->annotationLink($link, $current, $request)->body;
            $current = $this->nextLink($link, $current, $nextBody);
        }

        return $current;
    }

    /**
     * How next linked resource treated (add ? replace ?)
     */
    private function nextLink(LinkType $link, ResourceObject $ro, mixed $nextResource): ResourceObject
    {
        /** @var array<mixed> $nextBody */
        $nextBody = $nextResource instanceof ResourceObject ? $nextResource->body : $nextResource;

        if ($link->type === LinkType::SELF_LINK) {
            $ro->body = $nextBody;

            return $ro;
        }

        if ($link->type === LinkType::NEW_LINK) {
            assert(is_array($ro->body) || $ro->body === null);
            $ro->body[$link->key] = $nextBody;

            return $ro;
        }

        // crawl
        return $ro;
    }

    /**
     * Annotation link
     *
     * @throws MethodException
     * @throws LinkRelException
     * @throws Exception\LinkQueryException
     */
    private function annotationLink(LinkType $link, ResourceObject $current, AbstractRequest $request): ResourceObject
    {
        if (! is_array($current->body)) {
            throw new Exception\LinkQueryException('Only array is allowed for link in ' . $current::class, 500);
        }

        $classMethod = 'on' . ucfirst($request->method);
        /** @var list<Link> $annotations */
        $annotations = $this->reader->getMethodAnnotations(new ReflectionMethod($current::class, $classMethod));
        if ($link->type === LinkType::CRAWL_LINK) {
            return $this->annotationCrawl($annotations, $link, $current);
        }

        /* @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->annotationRel($annotations, $link, $current);
    }

    /**
     * Annotation link (new, self)
     *
     * @param Link[] $annotations
     *
     * @throws UriException
     * @throws MethodException
     * @throws Exception\LinkQueryException
     * @throws Exception\LinkRelException
     */
    private function annotationRel(array $annotations, LinkType $link, ResourceObject $current): ResourceObject
    {
        /* @noinspection LoopWhichDoesNotLoopInspection */
        foreach ($annotations as $annotation) {
            if ($annotation->rel !== $link->key) {
                continue;
            }

            $uri = uri_template($annotation->href, (array) $current->body);
            $rel = $this->factory->newInstance($uri);
            /* @noinspection UnnecessaryParenthesesInspection */
            $query = (new Uri($uri))->query;
            $request = new Request($this->invoker, $rel, Request::GET, $query);

            return $this->invoker->invoke($request);
        }

        throw new LinkRelException("rel:{$link->key} class:" . $current::class, 500);
    }

    /**
     * Link annotation crawl
     *
     * @param array<object> $annotations
     *
     * @throws MethodException
     */
    private function annotationCrawl(array $annotations, LinkType $link, ResourceObject $current): ResourceObject
    {
        $isList = $this->isList($current->body);
        /** @var array<array<string, mixed>> $bodyList */
        $bodyList = $isList ? (array) $current->body : [$current->body];
        foreach ($bodyList as &$body) {
            $this->crawl($annotations, $link, $body);
        }

        unset($body);
        $current->body = $isList ? $bodyList : $bodyList[0];

        return $current;
    }

    /**
     * @param array<object>        $annotations
     * @param array<string, mixed> $body
     *
     * @throws LinkQueryException
     * @throws MethodException
     * @throws LinkRelException
     * @throws UriException
     *
     * @param-out array $body
     */
    private function crawl(array $annotations, LinkType $link, array &$body): void
    {
        foreach ($annotations as $annotation) {
            if (! $annotation instanceof Link || $annotation->crawl !== $link->key) {
                continue;
            }

            $uri = uri_template($annotation->href, $body);
            $rel = $this->factory->newInstance($uri);
            /* @noinspection UnnecessaryParenthesesInspection */
            $query = (new Uri($uri))->query;
            $request = new Request($this->invoker, $rel, Request::GET, $query, [$link], $this);
            $hash = $request->hash();
            if (array_key_exists($hash, $this->cache)) {
                /** @var array<array<string, scalar|array<mixed>>>  $cachedResponse */
                $cachedResponse = $this->cache[$hash];
                $body[$annotation->rel] = $cachedResponse;
                continue;
            }

            $this->cache[$hash] = $body[$annotation->rel] = $this->getResponseBody($request);
        }
    }

    /** @return array<mixed> */
    private function getResponseBody(Request $request): array|null
    {
        $body = $this->invokeRecursive($request)->body;
        assert(is_array($body) || $body === null);

        return $body;
    }

    private function isList(mixed $value): bool
    {
        assert(is_array($value));
        /** @var array<array<mixed>|string> $list */
        $list = $value;
        /** @var array<mixed> $firstRow */
        $firstRow = array_pop($list);
        /** @var array<string, mixed>|string $firstRow */
        $keys = array_keys((array) $firstRow);
        $isMultiColumnMultiRowList = $this->isMultiColumnMultiRowList($keys, $list);
        $isMultiColumnList = $this->isMultiColumnList($value, $firstRow);
        $isSingleColumnList = $this->isSingleColumnList($value, $keys, $list);

        return $isSingleColumnList || $isMultiColumnMultiRowList || $isMultiColumnList;
    }

    /**
     * @param array<int, int|string>     $keys
     * @param array<array<mixed>|string> $list
     */
    private function isMultiColumnMultiRowList(array $keys, array $list): bool
    {
        if ($keys === [0 => 0]) {
            return false;
        }

        foreach ($list as $item) {
            if ($keys !== array_keys((array) $item)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array<int|string, mixed> $value
     * @psalm-param array<string, mixed>|scalar $firstRow
     */
    private function isMultiColumnList(array $value, mixed $firstRow): bool
    {
        return is_array($firstRow) && array_filter(array_keys($value), 'is_numeric') === array_keys($value);
    }

    /**
     * @param array<int|string, mixed> $value
     * @param list<array-key>          $keys
     * @param array<mixed, mixed>      $list
     */
    private function isSingleColumnList(array $value, array $keys, array $list): bool
    {
        return (count($value) === 1) && $keys === array_keys($list);
    }
}
