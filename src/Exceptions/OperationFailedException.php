<?php

declare(strict_types=1);

namespace Finvalda\Exceptions;

/**
 * Thrown when an operation fails with a specific error code (nResult > 0).
 */
class OperationFailedException extends FinvaldaException
{
    public function __construct(
        string $message,
        public readonly int $errorCode,
        public readonly ?string $journal = null,
        public readonly ?int $number = null,
    ) {
        parent::__construct($message, $errorCode);
    }
}
