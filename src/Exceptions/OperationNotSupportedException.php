<?php

declare(strict_types=1);

namespace Finvalda\Exceptions;

/**
 * Thrown when the connected Finvalda server build does not implement a requested
 * endpoint. The FvsServicePure service answers 404 for an action it does not
 * expose — e.g. `DeleteItem` exists only on newer Pure builds, while
 * `InsertNewItem` (create) and `EditItem` (update) are broadly available.
 */
class OperationNotSupportedException extends FinvaldaException
{
    public function __construct(
        string $message,
        public readonly string $endpoint,
    ) {
        parent::__construct($message, 404);
    }
}
