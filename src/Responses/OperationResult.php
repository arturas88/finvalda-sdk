<?php

declare(strict_types=1);

namespace Finvalda\Responses;

final class OperationResult
{
    public function __construct(
        public readonly bool $success,
        public readonly ?string $series = null,
        public readonly ?string $document = null,
        public readonly ?string $journal = null,
        public readonly ?int $number = null,
        public readonly ?string $error = null,
        public readonly ?int $errorCode = null,
    ) {}
}
