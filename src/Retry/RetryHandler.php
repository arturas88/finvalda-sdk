<?php

declare(strict_types=1);

namespace Finvalda\Retry;

use Finvalda\Exceptions\HttpException;
use Finvalda\Exceptions\NetworkException;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Handles request retries with exponential backoff.
 *
 * Sees SDK exceptions only: HttpClient maps (and credential-scrubs) Guzzle's
 * exceptions before they reach here, so the warning logged per failed attempt
 * is as safe to log as the exception a caller finally receives.
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
     * A non-retryable exception is thrown immediately. Once all attempts are
     * used, the last exception is thrown unchanged — so a caller catches the
     * same NetworkException/ServerException with or without a retry policy.
     *
     * @template T
     *
     * @param  callable(): T  $callable
     * @return T
     *
     * @throws Throwable
     */
    public function execute(callable $callable): mixed
    {
        $attempt = 0;

        while (true) {
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
                $attempt++;

                if ($attempt >= $this->policy->maxAttempts || ! $this->isRetryable($exception)) {
                    throw $exception;
                }

                $this->logger?->warning('Request failed, will retry', [
                    'attempt' => $attempt,
                    'error' => $exception->getMessage(),
                    'exception_class' => $exception::class,
                ]);
            }
        }
    }

    /**
     * Determine if an exception is eligible for retry based on the policy.
     */
    private function isRetryable(Throwable $exception): bool
    {
        if ($exception instanceof NetworkException) {
            return $this->policy->retryOnNetworkError;
        }

        if ($exception instanceof HttpException) {
            return $this->policy->isRetryableStatusCode($exception->getCode());
        }

        return false;
    }
}
