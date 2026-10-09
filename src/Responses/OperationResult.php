<?php

declare(strict_types=1);

namespace Finvalda\Responses;

use Finvalda\Exceptions\MissingCountryException;
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
     * The country code a failed write was refused for ("Country 'XX' not
     * found!"), or null. The server reports it under the generic error code
     * 2010, so the message is the only signal.
     */
    public function missingCountryCode(): ?string
    {
        if ($this->success || $this->error === null) {
            return null;
        }

        return preg_match("/Country '([^']*)' not found/", $this->error, $m) === 1 ? $m[1] : null;
    }

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
            $country = $this->missingCountryCode();

            if ($country !== null) {
                throw new MissingCountryException((string) $this->error, $code, $country, $this->journal, $this->number);
            }

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
