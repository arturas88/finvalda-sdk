<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Concerns\FormatsDate;
use Finvalda\HttpClient;

abstract class Resource
{
    use FormatsDate;

    public function __construct(
        protected readonly HttpClient $http,
    ) {}

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
