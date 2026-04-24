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
     * On a non-retryable exception, the original exception is thrown immediately.
     * On a retryable exception after all attempts are exhausted, a
     * RetryExhaustedException is thrown with the last exception as `previous`.
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
            } catch (Throwable $exception) {
                $lastException = $exception;

                if (! $this->isRetryable($exception)) {
                    throw $exception;
                }

                $this->logger?->warning('Request failed, will retry', [
                    'attempt' => $attempt + 1,
                    'error' => $exception->getMessage(),
                    'exception_class' => $exception::class,
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
     * Determine if an exception is eligible for retry based on the policy.
     */
    private function isRetryable(Throwable $exception): bool
    {
        if ($exception instanceof ConnectException || $exception instanceof NetworkException) {
            return $this->policy->retryOnNetworkError;
        }

        if ($exception instanceof RequestException && $exception->hasResponse()) {
            $statusCode = $exception->getResponse()->getStatusCode();

            return $this->policy->isRetryableStatusCode($statusCode);
        }

        if ($exception instanceof ServerException) {
            return true;
        }

        return false;
    }
}
