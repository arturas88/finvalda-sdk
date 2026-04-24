<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Exceptions\NetworkException;
use Finvalda\Exceptions\RetryExhaustedException;
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

    public function test_throws_retry_exhausted_after_all_attempts_fail(): void
    {
        $handler = new RetryHandler(new RetryPolicy(maxAttempts: 3, delayMs: 1));
        $calls = 0;

        try {
            $handler->execute(function () use (&$calls) {
                $calls++;
                throw new NetworkException('still failing');
            });
            $this->fail('Expected RetryExhaustedException was not thrown');
        } catch (RetryExhaustedException $exception) {
            $this->assertSame(3, $calls);
            $this->assertInstanceOf(NetworkException::class, $exception->getPrevious());
            $this->assertSame('still failing', $exception->getPrevious()->getMessage());
        }
    }
}
