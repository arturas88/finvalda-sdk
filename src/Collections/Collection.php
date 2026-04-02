<?php

declare(strict_types=1);

namespace Finvalda\Collections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Base collection class for typed entity collections.
 *
 * @template T
 *
 * @implements IteratorAggregate<int, T>
 * @implements ArrayAccess<int, T>
 *
 * @phpstan-consistent-constructor
 */
abstract class Collection implements IteratorAggregate, Countable, ArrayAccess
{
    /**
     * @param array<int, T> $items
     */
    public function __construct(
        protected array $items = [],
    ) {}

    /**
     * Create collection from API response data.
     *
     * @param  array<int, array<string, mixed>>  $data
     * @return static
     */
    abstract public static function fromArray(array $data): static;

    /**
     * @return Traversable<int, T>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return array<int, T>
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @return T|null
     */
    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    /**
     * @return T|null
     */
    public function last(): mixed
    {
        if (empty($this->items)) {
            return null;
        }

        return $this->items[array_key_last($this->items)];
    }

    /**
     * @param  int  $index
     * @return T|null
     */
    public function get(int $index): mixed
    {
        return $this->items[$index] ?? null;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function isNotEmpty(): bool
    {
        return ! empty($this->items);
    }

    /**
     * @param  callable(T): bool  $callback
     * @return static
     */
    public function filter(callable $callback): static
    {
        return new static(array_values(array_filter($this->items, $callback)));
    }

    /**
     * @template TMapValue
     *
     * @param  callable(T): TMapValue  $callback
     * @return array<int, TMapValue>
     */
    public function map(callable $callback): array
    {
        return array_map($callback, $this->items);
    }

    /**
     * @param  callable(T): void  $callback
     * @return static
     */
    public function each(callable $callback): static
    {
        foreach ($this->items as $item) {
            $callback($item);
        }

        return $this;
    }

    /**
     * @param  callable(T): mixed  $callback
     * @return array<mixed, static>
     */
    public function groupBy(callable $callback): array
    {
        $groups = [];
        foreach ($this->items as $item) {
            $key = $callback($item);
            $groups[$key] ??= [];
            $groups[$key][] = $item;
        }

        return array_map(fn (array $items) => new static($items), $groups);
    }

    /**
     * @param  string  $property
     * @return array<int, mixed>
     */
    public function pluck(string $property): array
    {
        return array_map(fn ($item) => $item->$property, $this->items);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function toArray(): array
    {
        return array_map(fn ($item) => $item->toArray(), $this->items);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @return T|null
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * @param  T  $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }
}
