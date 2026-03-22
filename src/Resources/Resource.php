<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
use Finvalda\HttpClient;

abstract class Resource
{
    public function __construct(
        protected readonly HttpClient $http,
    ) {}

    /**
     * Format a date parameter for the API.
     * Accepts DateTimeInterface objects or date strings in Y-m-d format.
     */
    protected function formatDate(DateTimeInterface|string|null $date): ?string
    {
        if ($date instanceof DateTimeInterface) {
            return $date->format('Y-m-d');
        }

        return $date;
    }

    /**
     * Safely encode data to JSON, throwing on failure.
     *
     * @throws \JsonException
     */
    protected function jsonEncode(mixed $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }
}
