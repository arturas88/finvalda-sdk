<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\FinvaldaConfig;
use Finvalda\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase
{
    private function createHttpClient(array $responses): HttpClient
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);
        $guzzle = new Client(['handler' => $handlerStack]);

        $config = new FinvaldaConfig(
            baseUrl: 'https://example.com',
            username: 'user',
            password: 'pass',
        );

        return new HttpClient($config, $guzzle);
    }

    public function test_operation_result_with_access_result_fail_and_nresult_zero_returns_failure(): void
    {
        $httpClient = $this->createHttpClient([
            new Response(200, [], json_encode([
                'AccessResult' => 'Fail',
                'error' => 'Service exception: Wrong ItemClassName.',
                'nResult' => 0,
            ])),
        ]);

        $result = $httpClient->postOperation('test-endpoint');

        $this->assertFalse($result->success);
        $this->assertSame('Service exception: Wrong ItemClassName.', $result->error);
        $this->assertSame(0, $result->errorCode);
    }

    public function test_operation_result_with_access_result_fail_captures_error_key(): void
    {
        $httpClient = $this->createHttpClient([
            new Response(200, [], json_encode([
                'AccessResult' => 'Fail',
                'error' => 'Some API error via error key',
                'nResult' => 0,
            ])),
        ]);

        $result = $httpClient->postOperation('test-endpoint');

        $this->assertFalse($result->success);
        $this->assertSame('Some API error via error key', $result->error);
    }

    public function test_operation_result_with_access_result_fail_prefers_serror_over_error(): void
    {
        $httpClient = $this->createHttpClient([
            new Response(200, [], json_encode([
                'AccessResult' => 'Fail',
                'sError' => 'Detailed error from sError',
                'error' => 'Generic error from error',
                'nResult' => 0,
            ])),
        ]);

        $result = $httpClient->postOperation('test-endpoint');

        $this->assertFalse($result->success);
        $this->assertSame('Detailed error from sError', $result->error);
    }

    public function test_operation_result_with_access_result_fail_uses_default_message_when_no_error(): void
    {
        $httpClient = $this->createHttpClient([
            new Response(200, [], json_encode([
                'AccessResult' => 'Fail',
                'nResult' => 0,
            ])),
        ]);

        $result = $httpClient->postOperation('test-endpoint');

        $this->assertFalse($result->success);
        $this->assertSame('Unknown error (AccessResult: Fail)', $result->error);
    }

    public function test_operation_result_with_access_result_ok_and_nresult_zero_returns_success(): void
    {
        $httpClient = $this->createHttpClient([
            new Response(200, [], json_encode([
                'AccessResult' => 'Success',
                'nResult' => 0,
            ])),
        ]);

        $result = $httpClient->postOperation('test-endpoint');

        $this->assertTrue($result->success);
        $this->assertNull($result->error);
        $this->assertNull($result->errorCode);
    }
}
