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
     * The first of $keys whose value is not null, as a string.
     *
     * A number in a Char column (an all-digit company code) becomes its
     * string; an empty XML element, which decodes to [], becomes null.
     *
     * @param  array<string, mixed>  $data
     */
    protected static function stringValue(array $data, string ...$keys): ?string
    {
        $value = self::first($data, $keys);

        return is_scalar($value) ? (string) $value : null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function intValue(array $data, string ...$keys): ?int
    {
        $value = self::first($data, $keys);

        return is_numeric($value) ? (int) $value : null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function floatValue(array $data, string ...$keys): ?float
    {
        $value = self::first($data, $keys);

        return is_numeric($value) ? (float) $value : null;
    }

    /**
     * A flag as Finvalda spells it: a bool, 0/1 (as int or string), or a
     * letter — N/F/false read false. Any other non-empty string reads true
     * (a code in a "belongs to" column), and an empty one false.
     *
     * @param  array<string, mixed>  $data
     */
    protected static function boolValue(array $data, string ...$keys): ?bool
    {
        $value = self::first($data, $keys);

        return match (true) {
            $value === null, is_array($value) => null,
            is_bool($value) => $value,
            is_numeric($value) => (float) $value !== 0.0,
            default => ! in_array(strtolower(trim((string) $value)), ['', 'n', 'f', 'false'], true),
        };
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<array-key, string>  $keys
     */
    private static function first(array $data, array $keys): mixed
    {
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                return $data[$key];
            }
        }

        return null;
    }

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
     *
     * @throws \LogicException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new \LogicException(static::class . ' is immutable; array writes are not supported.');
    }

    /**
     * Unset a field (not supported - entities are read-only).
     *
     * @throws \LogicException
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new \LogicException(static::class . ' is immutable; array writes are not supported.');
    }
}
