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

class HttpClientRedactionTest extends TestCase
{
    private function createHttpClient(array $responses, ?FinvaldaConfig $config = null): HttpClient
    {
        $mock = new MockHandler($responses);
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);

        $config ??= new FinvaldaConfig(
            baseUrl: 'https://example.com',
            username: 'user',
            password: 'secret-password',
        );

        return new HttpClient($config, $guzzle);
    }

    /**
     * @return \Psr\Log\AbstractLogger&object{records: list<array{level: mixed, message: string, context: array}>}
     */
    private function createSpyLogger(): object
    {
        return new class extends \Psr\Log\AbstractLogger
        {
            public array $records = [];

            public function log($level, string|\Stringable $message, array $context = []): void
            {
                $this->records[] = [
                    'level' => $level,
                    'message' => (string) $message,
                    'context' => $context,
                ];
            }
        };
    }

    public function test_debug_info_redacts_password_and_conn_string_headers(): void
    {
        $config = new FinvaldaConfig(
            baseUrl: 'https://example.com',
            username: 'user',
            password: 'secret-password',
            connString: 'Server=db;User=sa;Password=db-secret',
        );

        $httpClient = $this->createHttpClient([
            new Response(200, [], json_encode(['AccessResult' => 'Success', 'nResult' => 0])),
        ], $config);

        $httpClient->setDebug(true);
        $httpClient->postOperation('InsertNewItem', ['ItemClassName' => 'Fvs.Preke']);

        $headers = $httpClient->getLastDebugInfo()['request']['headers'];

        $this->assertSame('***', $headers['Password']);
        $this->assertSame('***', $headers['ConnString']);
        $this->assertStringNotContainsString('secret-password', json_encode($headers));
        // Non-sensitive headers stay intact
        $this->assertSame('user', $headers['UserName']);
    }

    public function test_log_request_redacts_password_query_params(): void
    {
        $logger = $this->createSpyLogger();
        $httpClient = $this->createHttpClient([
            new Response(200, [], json_encode(['AccessResult' => 'Success'])),
        ]);
        $httpClient->setLogger($logger);

        // References::user() sends credentials as query params (GetFvsUser)
        $httpClient->get('GetFvsUser', [
            'sUserName' => 'someuser',
            'sPassword' => 'user-secret',
        ]);

        $params = $logger->records[0]['context']['params'];

        $this->assertSame('***', $params['sPassword']);
        $this->assertSame('someuser', $params['sUserName']);
        $this->assertStringNotContainsString('user-secret', json_encode($logger->records));
    }
}
