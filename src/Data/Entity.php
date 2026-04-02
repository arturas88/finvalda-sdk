<?php

declare(strict_types=1);

namespace Finvalda\Data;

use ArrayAccess;

/**
 * Base class for typed entity DTOs.
 *
 * @implements ArrayAccess<string, mixed>
 */
abstract class Entity implements ArrayAccess
{
    /**
     * The original raw data from the API response.
     *
     * @var array<string, mixed>
     */
    protected array $raw = [];

    /**
     * Create a new entity instance from an API response array.
     *
     * @param  array<string, mixed>  $data
     * @return static
     */
    abstract public static function fromArray(array $data): static;

    /**
     * Convert the entity back to an array for API requests.
     *
     * @return array<string, mixed>
     */
    abstract public function toArray(): array;

    /**
     * Get the raw API response data.
     *
     * @return array<string, mixed>
     */
    public function getRaw(): array
    {
        return $this->raw;
    }

    /**
     * Check if a field exists in the raw data.
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->raw[$offset]);
    }

    /**
     * Get a field from the raw data.
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->raw[$offset] ?? null;
    }

    /**
     * Set a field (not supported - entities are read-only).
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        // Entities are immutable
    }

    /**
     * Unset a field (not supported - entities are read-only).
     */
    public function offsetUnset(mixed $offset): void
    {
        // Entities are immutable
    }
}
