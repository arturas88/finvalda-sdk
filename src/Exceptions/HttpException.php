<?php

declare(strict_types=1);

namespace Finvalda\Exceptions;

use Psr\Http\Message\ResponseInterface;

/**
 * Thrown when the server answers with an HTTP error status. The status is the
 * exception code; the response itself is kept for inspection.
 *
 * Guzzle's exception is deliberately not chained as `previous`: its message
 * embeds the request URI, and GetFvsUser carries a password in the query, so an
 * error tracker walking the chain would record it.
 */
class HttpException extends FinvaldaException
{
    public function __construct(
        string $message,
        public readonly ?ResponseInterface $response = null,
    ) {
        parent::__construct($message, $response?->getStatusCode() ?? 0);
    }
}
