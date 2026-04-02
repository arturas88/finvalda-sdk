<?php

declare(strict_types=1);

namespace Finvalda\Retry;

use Finvalda\Exceptions\NetworkException;
use Finvalda\Exceptions\RetryExhaustedException;
use Finvalda\Exceptions\ServerException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Handles request retries with exponential backoff.
 */
final class RetryHandler
{
    public function __construct(
        private readonly RetryPolicy $policy,
        private readonly ?LoggerInterface $logger = null,
    ) {}

    /**
     * Execute a callable with retry logic.
     *
     * @template T
     *
     * @param  callable(): T  $callable
     * @return T
     *
     * @throws RetryExhaustedException
     * @throws Throwable
     */
    public function execute(callable $callable): mixed
    {
        $lastException = null;
        $attempt = 0;

        while ($attempt < $this->policy->maxAttempts) {
            if ($attempt > 0) {
                $delayMs = $this->policy->getDelayForAttempt($attempt);
                $this->logger?->debug('Retrying request', [
                    'attempt' => $attempt + 1,
                    'max_attempts' => $this->policy->maxAttempts,
                    'delay_ms' => $delayMs,
                ]);
                usleep($delayMs * 1000);
            }

            try {
                return $callable();
            } catch (Throwable $e) {
                $lastException = $e;

                if (! $this->shouldRetry($e, $attempt)) {
                    throw $e;
                }

                $this->logger?->warning('Request failed, will retry', [
                    'attempt' => $attempt + 1,
                    'error' => $e->getMessage(),
                    'exception_class' => $e::class,
                ]);
            }

            $attempt++;
        }

        throw new RetryExhaustedException(
            "Request failed after {$this->policy->maxAttempts} attempts: " . ($lastException?->getMessage() ?? 'Unknown error'),
            $this->policy->maxAttempts,
            $lastException,
        );
    }

    /**
     * Determine if we should retry based on the exception.
     */
    private function shouldRetry(Throwable $e, int $currentAttempt): bool
    {
        // Don't retry if we've exhausted attempts
        if ($currentAttempt + 1 >= $this->policy->maxAttempts) {
            return false;
        }

        // Network errors (connection failures, timeouts)
        if ($e instanceof ConnectException || $e instanceof NetworkException) {
            return $this->policy->retryOnNetworkError;
        }

        // HTTP errors with retryable status codes
        if ($e instanceof RequestException && $e->hasResponse()) {
            $statusCode = $e->getResponse()->getStatusCode();

            return $this->policy->isRetryableStatusCode($statusCode);
        }

        // Server exceptions (5xx mapped by HttpClient)
        if ($e instanceof ServerException) {
            return true;
        }

        return false;
    }
}
