<?php

declare(strict_types=1);

namespace Finvalda\Support;

use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Reads a Guzzle exception the same way on Guzzle 7 and Guzzle 8.
 *
 * Guzzle 7 keeps the response on RequestException (getResponse() may be null,
 * hasResponse()). Guzzle 8 keeps it only on ResponseException and its
 * subclasses (ClientException, ServerException, ResponseTransferException…);
 * there RequestException has neither getResponse() nor hasResponse().
 *
 * A failure before any response is a ConnectException on Guzzle 7. Guzzle 8
 * adds NetworkTimeoutException beside ConnectException; both versions mark all
 * of them with PSR-18 NetworkExceptionInterface.
 */
final class GuzzleResponse
{
    public static function of(Throwable $e): ?ResponseInterface
    {
        if (! method_exists($e, 'getResponse')) {
            return null;
        }

        $response = $e->getResponse();

        return $response instanceof ResponseInterface ? $response : null;
    }

    public static function isNetworkFailure(Throwable $e): bool
    {
        return $e instanceof NetworkExceptionInterface;
    }
}
