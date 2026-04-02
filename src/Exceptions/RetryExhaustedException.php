<?php

declare(strict_types=1);

namespace Finvalda\Exceptions;

use Throwable;

/**
 * Thrown when all retry attempts have been exhausted.
 */
class RetryExhaustedException extends FinvaldaException
{
    public function __construct(
        string $message,
        public readonly int $attempts,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }
}
