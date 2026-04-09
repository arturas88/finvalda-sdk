<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\FinvaldaConfig;
use Finvalda\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
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

    private function createHttpClientWithHistory(array $responses, array &$history): HttpClient
    {
        $mock = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mock);
        $handlerStack->push(Middleware::history($history));
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

    public function test_post_operation_sends_json_body_with_xmlstring(): void
    {
        $history = [];
        $httpClient = $this->createHttpClientWithHistory([
            new Response(200, [], json_encode([
                'AccessResult' => 'Success',
                'nResult' => 0,
            ])),
        ], $history);

        $jsonBody = '{"PardDok":{"sKlientas":"TEST"}}';

        $httpClient->postOperation('InsertNewOperation', [
            'ItemClassName' => 'PardDok',
            'sParametras' => 'PARAM1',
        ], $jsonBody);

        $this->assertCount(1, $history);

        $request = $history[0]['request'];
        $this->assertSame('POST', $request->getMethod());
        $this->assertStringContainsString('application/json', $request->getHeaderLine('Content-Type'));

        // Query string should be empty — everything goes in JSON body
        $this->assertEmpty($request->getUri()->getQuery());

        // Parse the JSON body
        $body = json_decode((string) $request->getBody(), true);

        $this->assertSame('PardDok', $body['ItemClassName']);
        $this->assertSame('PARAM1', $body['sParametras']);
        $this->assertSame($jsonBody, $body['xmlstring']);
    }

    public function test_post_operation_without_body_sends_json_without_xmlstring(): void
    {
        $history = [];
        $httpClient = $this->createHttpClientWithHistory([
            new Response(200, [], json_encode([
                'AccessResult' => 'Success',
                'nResult' => 0,
            ])),
        ], $history);

        $httpClient->postOperation('InsertNewItem', [
            'ItemClassName' => 'Fvs.Klientas',
            'xmlstring' => '{"Fvs.Klientas":{"sKodas":"K001"}}',
        ]);

        $request = $history[0]['request'];
        $body = json_decode((string) $request->getBody(), true);

        $this->assertSame('Fvs.Klientas', $body['ItemClassName']);
        $this->assertSame('{"Fvs.Klientas":{"sKodas":"K001"}}', $body['xmlstring']);
    }

    public function test_post_operation_json_sends_json_body(): void
    {
        $history = [];
        $httpClient = $this->createHttpClientWithHistory([
            new Response(200, [], json_encode([
                'AccessResult' => 'Success',
                'nResult' => 0,
            ])),
        ], $history);

        $httpClient->postOperationJson('LockOperation', [
            'sZurnalas' => '$PARD.',
            'nNumeris' => 49193,
        ]);

        $request = $history[0]['request'];
        $this->assertSame('POST', $request->getMethod());
        $this->assertStringContainsString('application/json', $request->getHeaderLine('Content-Type'));

        $body = json_decode((string) $request->getBody(), true);
        $this->assertSame('$PARD.', $body['sZurnalas']);
        $this->assertSame(49193, $body['nNumeris']);
    }

    public function test_get_request_uses_query_params(): void
    {
        $history = [];
        $httpClient = $this->createHttpClientWithHistory([
            new Response(200, [], json_encode([
                'AccessResult' => 'Success',
            ])),
        ], $history);

        $httpClient->get('GetOperations', [
            'OpClass' => 'Sales',
            'DateFrom' => '2024-01-01',
        ]);

        $request = $history[0]['request'];
        $this->assertSame('GET', $request->getMethod());

        $query = $request->getUri()->getQuery();
        $this->assertStringContainsString('OpClass=Sales', $query);
        $this->assertStringContainsString('DateFrom=2024-01-01', $query);

        // GET body should be empty
        $this->assertEmpty((string) $request->getBody());
    }

    public function test_debug_captures_request_and_response_when_enabled(): void
    {
        $httpClient = $this->createHttpClient([
            new Response(200, ['X-Custom' => 'test'], json_encode([
                'AccessResult' => 'Success',
                'nResult' => 0,
            ])),
        ]);

        $httpClient->setDebug(true);

        $httpClient->postOperation('InsertNewOperation', [
            'ItemClassName' => 'PardDok',
        ], '{"PardDok":{}}');

        $debug = $httpClient->getLastDebugInfo();

        $this->assertSame('POST', $debug['request']['method']);
        $this->assertStringContainsString('InsertNewOperation', $debug['request']['url']);
        $this->assertIsArray($debug['request']['headers']);
        $this->assertIsArray($debug['request']['body']);
        $this->assertSame('PardDok', $debug['request']['body']['ItemClassName'] ?? null);
        $this->assertSame('{"PardDok":{}}', $debug['request']['body']['xmlstring'] ?? null);

        $this->assertSame(200, $debug['response']['status_code']);
        $this->assertIsArray($debug['response']['headers']);
        $this->assertIsString($debug['response']['body']);
    }

    public function test_debug_info_is_empty_when_disabled(): void
    {
        $httpClient = $this->createHttpClient([
            new Response(200, [], json_encode([
                'AccessResult' => 'Success',
                'nResult' => 0,
            ])),
        ]);

        $httpClient->postOperation('test-endpoint');

        $debug = $httpClient->getLastDebugInfo();

        $this->assertEmpty($debug['request']);
        $this->assertEmpty($debug['response']);
    }

    public function test_set_debug_false_clears_previous_debug_info(): void
    {
        $httpClient = $this->createHttpClient([
            new Response(200, [], json_encode([
                'AccessResult' => 'Success',
                'nResult' => 0,
            ])),
        ]);

        $httpClient->setDebug(true);
        $httpClient->postOperation('test-endpoint');

        // Debug info should be populated
        $this->assertNotEmpty($httpClient->getLastDebugInfo()['request']);

        // Disabling debug should clear it
        $httpClient->setDebug(false);
        $debug = $httpClient->getLastDebugInfo();

        $this->assertEmpty($debug['request']);
        $this->assertEmpty($debug['response']);
    }
}
