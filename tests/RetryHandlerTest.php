<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Exceptions\NetworkException;
use Finvalda\Retry\RetryHandler;
use Finvalda\Retry\RetryPolicy;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class RetryHandlerTest extends TestCase
{
    public function test_returns_result_on_first_successful_attempt(): void
    {
        $handler = new RetryHandler(new RetryPolicy(maxAttempts: 3, delayMs: 1));

        $result = $handler->execute(fn () => 'ok');

        $this->assertSame('ok', $result);
    }

    public function test_retries_on_retryable_exception_and_returns_eventual_success(): void
    {
        $handler = new RetryHandler(new RetryPolicy(maxAttempts: 3, delayMs: 1));
        $calls = 0;

        $result = $handler->execute(function () use (&$calls) {
            $calls++;
            if ($calls < 3) {
                throw new NetworkException('transient');
            }

            return 'ok';
        });

        $this->assertSame('ok', $result);
        $this->assertSame(3, $calls);
    }

    public function test_throws_original_exception_immediately_on_non_retryable(): void
    {
        $handler = new RetryHandler(new RetryPolicy(maxAttempts: 3, delayMs: 1));
        $calls = 0;

        try {
            $handler->execute(function () use (&$calls) {
                $calls++;
                throw new RuntimeException('boom');
            });
            $this->fail('Expected exception was not thrown');
        } catch (RuntimeException $exception) {
            $this->assertSame('boom', $exception->getMessage());
            $this->assertSame(1, $calls);
        }
    }

    public function test_rethrows_the_last_exception_after_all_attempts_fail(): void
    {
        $handler = new RetryHandler(new RetryPolicy(maxAttempts: 3, delayMs: 1));
        $calls = 0;

        try {
            $handler->execute(function () use (&$calls) {
                $calls++;
                throw new NetworkException("still failing {$calls}");
            });
            $this->fail('Expected NetworkException was not thrown');
        } catch (NetworkException $exception) {
            $this->assertSame(3, $calls);
            $this->assertSame('still failing 3', $exception->getMessage());
        }
    }

    public function test_a_single_attempt_policy_runs_once_and_rethrows(): void
    {
        $handler = new RetryHandler(RetryPolicy::noRetry());
        $calls = 0;

        try {
            $handler->execute(function () use (&$calls) {
                $calls++;
                throw new NetworkException('down');
            });
            $this->fail('Expected NetworkException was not thrown');
        } catch (NetworkException) {
            $this->assertSame(1, $calls);
        }
    }
}
