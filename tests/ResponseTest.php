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

    public function test_throw_returns_a_successful_response_unchanged(): void
    {
        $response = new Response(accessResult: AccessResult::Success, data: ['a' => 1]);

        $this->assertSame($response, $response->throw());
    }

    public function test_throw_raises_the_server_error_for_a_failed_response(): void
    {
        $response = new Response(accessResult: AccessResult::Fail, data: [], error: 'Klientas nerastas');

        $this->expectException(\Finvalda\Exceptions\FinvaldaException::class);
        $this->expectExceptionMessage('Klientas nerastas');

        $response->throw();
    }

    public function test_throw_names_the_access_result_when_the_server_gave_no_error(): void
    {
        $response = new Response(accessResult: AccessResult::Fail, data: []);

        $this->expectException(\Finvalda\Exceptions\FinvaldaException::class);
        $this->expectExceptionMessage('AccessResult: Fail');

        $response->throw();
    }
}
