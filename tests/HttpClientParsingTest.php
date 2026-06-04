<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Exceptions\AccessDeniedException;
use Finvalda\FinvaldaConfig;
use Finvalda\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class HttpClientParsingTest extends TestCase
{
    private function createHttpClient(array $responses): HttpClient
    {
        $mock = new MockHandler($responses);
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);

        $config = new FinvaldaConfig(
            baseUrl: 'https://example.com',
            username: 'user',
            password: 'pass',
        );

        return new HttpClient($config, $guzzle);
    }

    public function test_parse_response_handles_xml_bodies(): void
    {
        // GetFvsUser ignores the JSON Accept header on some server versions
        // and returns XML (observed live), which broke ping().
        $httpClient = $this->createHttpClient([
            new Response(200, [], '<root><AccessResult>Success</AccessResult><error></error></root>'),
        ]);

        $response = $httpClient->get('GetFvsUser');

        $this->assertTrue($response->successful());
        $this->assertNull($response->error);
    }

    public function test_parse_response_handles_xml_access_denied(): void
    {
        $httpClient = $this->createHttpClient([
            new Response(200, [], '<root><AccessResult>AccessDenied</AccessResult><error>Bad credentials</error></root>'),
        ]);

        $this->expectException(AccessDeniedException::class);
        $this->expectExceptionMessage('Bad credentials');

        $httpClient->get('GetFvsUser');
    }

    public function test_operation_result_access_denied_includes_server_message(): void
    {
        // Observed live: the server explains WHY access was denied; the SDK
        // used to discard it and throw a bare "Access denied".
        $httpClient = $this->createHttpClient([
            new Response(200, [], json_encode([
                'AccessResult' => 'AccessDenied',
                'error' => 'This function is not licensed in this machine!',
                'nResult' => 0,
            ])),
        ]);

        $this->expectException(AccessDeniedException::class);
        $this->expectExceptionMessage('This function is not licensed in this machine!');

        $httpClient->postOperation('InsertNewOperation');
    }
}
