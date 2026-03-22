<?php

declare(strict_types=1);

namespace Finvalda\Responses;

use Finvalda\Enums\AccessResult;

final class Response
{
    public function __construct(
        public readonly AccessResult $accessResult,
        public readonly array $data,
        public readonly ?string $error = null,
        public readonly array $raw = [],
    ) {}

    public function successful(): bool
    {
        return $this->accessResult === AccessResult::Success;
    }

    public function failed(): bool
    {
        return ! $this->successful();
    }
}
