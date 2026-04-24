<?php

declare(strict_types=1);

namespace Finvalda\Tests\Concerns;

use Finvalda\FinvaldaConfig;
use Finvalda\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

trait CreatesMockHttpClient
{
    /**
     * @param  list<GuzzleResponse>  $responses
     * @param  array<int, array<string, mixed>>  $history
     */
    private function createHttpClient(array $responses, array &$history = []): HttpClient
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

    /**
     * @param  array<string, mixed>  $body
     */
    private function jsonResponse(array $body, int $status = 200): GuzzleResponse
    {
        return new GuzzleResponse($status, [], json_encode($body, JSON_THROW_ON_ERROR));
    }
}
