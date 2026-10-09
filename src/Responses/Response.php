<?php

declare(strict_types=1);

namespace Finvalda\Responses;

use Finvalda\Enums\AccessResult;
use Finvalda\Exceptions\FinvaldaException;

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

    /**
     * Return this response if it succeeded, otherwise throw — so a caller can
     * write `$finvalda->clients()->get('X')->throw()->data` instead of
     * checking failed() by hand.
     *
     * @throws FinvaldaException
     */
    public function throw(): self
    {
        if ($this->failed()) {
            throw new FinvaldaException(
                $this->error ?? "Finvalda request failed (AccessResult: {$this->accessResult->value})"
            );
        }

        return $this;
    }
}
