<?php

declare(strict_types=1);

namespace Finvalda\Responses;

use Finvalda\Exceptions\OperationFailedException;

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

    /**
     * Return this result if the operation succeeded, otherwise throw an
     * OperationFailedException carrying the server's error code.
     *
     * @throws OperationFailedException
     */
    public function throw(): self
    {
        if (! $this->success) {
            $code = $this->errorCode ?? -1;

            throw new OperationFailedException(
                $this->error ?? "Finvalda operation failed (code {$code})",
                $code,
                $this->journal,
                $this->number,
            );
        }

        return $this;
    }
}
