<?php

declare(strict_types=1);

namespace Finvalda\Query;

use DateTimeInterface;
use Finvalda\Concerns\FormatsDate;

/**
 * Base fluent query builder for constructing API parameters.
 */
abstract class QueryBuilder
{
    use FormatsDate;

    /** @var array<string, mixed> */
    protected array $params = [];

    /**
     * Set a parameter value.
     *
     * @return $this
     */
    protected function set(string $key, mixed $value): static
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * Set a date parameter value.
     *
     * @return $this
     */
    protected function setDate(string $key, DateTimeInterface|string|null $value): static
    {
        $this->params[$key] = $this->formatDate($value);

        return $this;
    }

    /**
     * Build the query parameters array.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        return array_filter($this->params, fn ($v) => $v !== null);
    }

    /**
     * Alias for build().
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->build();
    }
}
