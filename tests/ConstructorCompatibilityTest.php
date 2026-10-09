<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\AccessResult;
use Finvalda\FinvaldaConfig;
use Finvalda\Recording\Exchange;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;
use PHPUnit\Framework\TestCase;

/**
 * Consumers construct these value objects directly, by name and by position
 * (one app builds Exchange with 9 positional arguments in a test). v4 may add
 * parameters only last and optional; these calls are the v3 shapes.
 */
class ConstructorCompatibilityTest extends TestCase
{
    public function test_v3_named_and_positional_constructor_calls_still_work(): void
    {
        $result = new OperationResult(success: false, error: 'boom');
        $this->assertSame('boom', $result->error);

        $response = new Response(AccessResult::Success, ['a' => 1], null, ['raw' => true]);
        $this->assertSame(['a' => 1], $response->data);

        $config = new FinvaldaConfig(
            baseUrl: 'https://example.com',
            username: 'u',
            password: 'p',
            removeEmptyStringTags: true,
            timeout: 300,
        );
        $this->assertSame(300, $config->timeout);
        $this->assertSame([], $config->httpOptions);

        $exchange = new Exchange('GET', 'https://example.com/GetX', [], null, 200, 'OK', [], '{}', 12.5);
        $this->assertSame(1, $exchange->attempt);
        $this->assertNull($exchange->requestId);
    }
}
