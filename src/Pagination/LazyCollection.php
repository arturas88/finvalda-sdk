<?php

declare(strict_types=1);

namespace Finvalda\Pagination;

use ArrayIterator;
use Countable;
use Generator;
use IteratorAggregate;
use Traversable;

/**
 * A lazy collection that wraps a generator for memory-efficient iteration.
 *
 * @template T
 *
 * @implements IteratorAggregate<int, T>
 */
final class LazyCollection implements IteratorAggregate, Countable
{
    /** @var callable(): Generator<int, T> */
    private mixed $source;

    /** @var array<int, T>|null */
    private ?array $cached = null;

    /**
     * @param  callable(): Generator<int, T>  $source
     */
    public function __construct(callable $source)
    {
        $this->source = $source;
    }

    /**
     * Create from an iterable.
     *
     * @template TValue
     *
     * @param  iterable<TValue>  $items
     * @return self<TValue>
     */
    public static function make(iterable $items): self
    {
        return new self(function () use ($items): Generator {
            foreach ($items as $item) {
                yield $item;
            }
        });
    }

    /**
     * @return Traversable<int, T>
     */
    public function getIterator(): Traversable
    {
        if ($this->cached !== null) {
            return new ArrayIterator($this->cached);
        }

        return ($this->source)();
    }

    /**
     * Get all items as an array (caches result).
     *
     * @return array<int, T>
     */
    public function all(): array
    {
        if ($this->cached === null) {
            $this->cached = iterator_to_array($this->getIterator(), false);
        }

        return $this->cached;
    }

    /**
     * Get the first item.
     *
     * @return T|null
     */
    public function first(): mixed
    {
        foreach ($this->getIterator() as $item) {
            return $item;
        }

        return null;
    }

    /**
     * Get the last item (caches all items).
     *
     * @return T|null
     */
    public function last(): mixed
    {
        $items = $this->all();

        return empty($items) ? null : $items[array_key_last($items)];
    }

    public function count(): int
    {
        return count($this->all());
    }

    public function isEmpty(): bool
    {
        return $this->first() === null;
    }

    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    /**
     * Take the first N items.
     *
     * @return self<T>
     */
    public function take(int $limit): self
    {
        $source = $this->source;

        return new self(function () use ($source, $limit): Generator {
            $count = 0;
            foreach ($source() as $item) {
                if ($count >= $limit) {
                    break;
                }
                yield $item;
                $count++;
            }
        });
    }

    /**
     * Skip the first N items.
     *
     * @return self<T>
     */
    public function skip(int $count): self
    {
        $source = $this->source;

        return new self(function () use ($source, $count): Generator {
            $skipped = 0;
            foreach ($source() as $item) {
                if ($skipped < $count) {
                    $skipped++;

                    continue;
                }
                yield $item;
            }
        });
    }

    /**
     * Filter items using a callback.
     *
     * @param  callable(T): bool  $callback
     * @return self<T>
     */
    public function filter(callable $callback): self
    {
        $source = $this->source;

        return new self(function () use ($source, $callback): Generator {
            foreach ($source() as $item) {
                if ($callback($item)) {
                    yield $item;
                }
            }
        });
    }

    /**
     * Map items using a callback.
     *
     * @template TMapValue
     *
     * @param  callable(T): TMapValue  $callback
     * @return self<TMapValue>
     */
    public function map(callable $callback): self
    {
        $source = $this->source;

        return new self(function () use ($source, $callback): Generator {
            foreach ($source() as $item) {
                yield $callback($item);
            }
        });
    }

    /**
     * Execute a callback for each item.
     *
     * @param  callable(T): void  $callback
     * @return self<T>
     */
    public function each(callable $callback): self
    {
        foreach ($this->getIterator() as $item) {
            $callback($item);
        }

        return $this;
    }

    /**
     * Chunk items into groups.
     *
     * @return self<array<int, T>>
     */
    public function chunk(int $size): self
    {
        $source = $this->source;

        return new self(function () use ($source, $size): Generator {
            $chunk = [];
            foreach ($source() as $item) {
                $chunk[] = $item;
                if (count($chunk) >= $size) {
                    yield $chunk;
                    $chunk = [];
                }
            }
            if (! empty($chunk)) {
                yield $chunk;
            }
        });
    }

    /**
     * Pluck a property from each item.
     *
     * @return self<mixed>
     */
    public function pluck(string $property): self
    {
        return $this->map(fn ($item) => $item->$property);
    }
}
