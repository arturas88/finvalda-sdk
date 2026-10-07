<?php

declare(strict_types=1);

namespace Finvalda\Retry;

use InvalidArgumentException;

/**
 * Configuration for retry behavior. Applies to reads only: HttpClient never
 * retries a write, since a timeout after the request went out may mean the
 * server already committed it.
 */
final class RetryPolicy
{
    /**
     * @param  int  $maxAttempts  Maximum number of attempts (including the initial request)
     * @param  int  $delayMs  Initial delay between retries in milliseconds
     * @param  float  $multiplier  Multiplier for exponential backoff (delay = delayMs * multiplier^attempt)
     * @param  int  $maxDelayMs  Maximum delay between retries in milliseconds
     * @param  array<int>  $retryableStatusCodes  HTTP status codes that should trigger a retry
     * @param  bool  $retryOnNetworkError  Whether to retry on network errors (timeouts, connection failures)
     */
    public function __construct(
        public readonly int $maxAttempts = 3,
        public readonly int $delayMs = 100,
        public readonly float $multiplier = 2.0,
        public readonly int $maxDelayMs = 10000,
        public readonly array $retryableStatusCodes = [429, 500, 502, 503, 504],
        public readonly bool $retryOnNetworkError = true,
    ) {
        if ($this->maxAttempts < 1) {
            throw new InvalidArgumentException('Retry maxAttempts must be at least 1 (the initial request)');
        }
    }

    /**
     * Create a policy that does not retry.
     */
    public static function noRetry(): self
    {
        return new self(maxAttempts: 1);
    }

    /**
     * Create a default retry policy.
     */
    public static function default(): self
    {
        return new self();
    }

    /**
     * Create a policy for conservative retrying.
     */
    public static function conservative(): self
    {
        return new self(
            maxAttempts: 3,
            delayMs: 500,
            multiplier: 3.0,
            maxDelayMs: 30000,
        );
    }

    /**
     * Calculate the delay for a given attempt number (0-indexed).
     */
    public function getDelayForAttempt(int $attempt): int
    {
        if ($attempt <= 0) {
            return 0;
        }

        $delay = (int) ($this->delayMs * ($this->multiplier ** ($attempt - 1)));

        return min($delay, $this->maxDelayMs);
    }

    /**
     * Check if a status code is retryable.
     */
    public function isRetryableStatusCode(int $statusCode): bool
    {
        return in_array($statusCode, $this->retryableStatusCodes, true);
    }
}
