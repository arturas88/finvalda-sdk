<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\AccessResult;
use Finvalda\Responses\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function test_successful_response(): void
    {
        $response = new Response(
            accessResult: AccessResult::Success,
            data: ['foo' => 'bar'],
        );

        $this->assertTrue($response->successful());
        $this->assertFalse($response->failed());
        $this->assertSame(['foo' => 'bar'], $response->data);
        $this->assertNull($response->error);
    }

    public function test_failed_response(): void
    {
        $response = new Response(
            accessResult: AccessResult::Fail,
            data: [],
            error: 'Something went wrong',
        );

        $this->assertFalse($response->successful());
        $this->assertTrue($response->failed());
        $this->assertSame('Something went wrong', $response->error);
    }

    public function test_access_denied_response(): void
    {
        $response = new Response(
            accessResult: AccessResult::AccessDenied,
            data: [],
            error: 'Access denied',
        );

        $this->assertFalse($response->successful());
        $this->assertTrue($response->failed());
    }

    public function test_raw_data_is_preserved(): void
    {
        $raw = ['AccessResult' => 'Success', 'items' => [1, 2, 3]];

        $response = new Response(
            accessResult: AccessResult::Success,
            data: [1, 2, 3],
            raw: $raw,
        );

        $this->assertSame($raw, $response->raw);
    }
}
