<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Exceptions\NetworkException;
use Finvalda\Exceptions\ServerException;
use Finvalda\FinvaldaConfig;
use Finvalda\HttpClient;
use Finvalda\Retry\RetryPolicy;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;
use Stringable;

class HttpClientTransportTest extends TestCase
{
    /** @var array<int, array<string, mixed>> */
    private array $history = [];

    private function httpClient(array $responses, ?FinvaldaConfig $config = null): HttpClient
    {
        $this->history = [];
        $stack = HandlerStack::create(new MockHandler($responses));
        $stack->push(Middleware::history($this->history));

        return new HttpClient(
            $config ?? new FinvaldaConfig(baseUrl: 'https://example.com/svc', username: 'u', password: 'p'),
            new Client(['handler' => $stack]),
        );
    }

    private function config(mixed ...$overrides): FinvaldaConfig
    {
        return new FinvaldaConfig(...[
            'baseUrl' => 'https://example.com/svc',
            'username' => 'u',
            'password' => 'connection-password',
            ...$overrides,
        ]);
    }

    /**
     * @return AbstractLogger&object{records: list<array{0: string, 1: string, 2: array}>}
     */
    private function spyLogger(): object
    {
        return new class extends AbstractLogger
        {
            public array $records = [];

            public function log($level, string|Stringable $message, array $context = []): void
            {
                $this->records[] = [(string) $level, (string) $message, $context];
            }
        };
    }

    private function timeout(string $endpoint): ConnectException
    {
        return new ConnectException('cURL error 28: Operation timed out', new Request('POST', $endpoint));
    }

    private function ok(array $body = ['AccessResult' => 'Success', 'nResult' => 0]): Response
    {
        return new Response(200, [], json_encode($body));
    }

    public function test_a_write_is_never_retried_even_with_a_retry_policy(): void
    {
        // A timeout after the request went out may mean the server already
        // committed the operation: a second attempt would post it twice.
        $httpClient = $this->httpClient(
            [$this->timeout('InsertNewOperation'), $this->ok()],
            $this->config(retry: new RetryPolicy(maxAttempts: 3, delayMs: 1)),
        );

        try {
            $httpClient->postOperation('InsertNewOperation', ['ItemClassName' => 'PardDok'], '{}');
            $this->fail('Expected NetworkException');
        } catch (NetworkException) {
        }

        $this->assertCount(1, $this->history);
    }

    public function test_a_flat_json_write_is_never_retried(): void
    {
        $httpClient = $this->httpClient(
            [$this->timeout('DeleteItem'), $this->ok()],
            $this->config(retry: new RetryPolicy(maxAttempts: 3, delayMs: 1)),
        );

        try {
            $httpClient->postOperationJson('DeleteItem', ['input' => ['Code' => 'X']]);
            $this->fail('Expected NetworkException');
        } catch (NetworkException) {
        }

        $this->assertCount(1, $this->history);
    }

    public function test_a_read_is_retried(): void
    {
        $httpClient = $this->httpClient(
            [$this->timeout('GetPrekes'), $this->ok(['AccessResult' => 'Success'])],
            $this->config(retry: new RetryPolicy(maxAttempts: 3, delayMs: 1)),
        );

        $this->assertTrue($httpClient->get('GetPrekes')->successful());
        $this->assertCount(2, $this->history);
    }

    public function test_exhausted_retries_rethrow_the_mapped_exception(): void
    {
        $httpClient = $this->httpClient(
            [new Response(503), new Response(503)],
            $this->config(retry: new RetryPolicy(maxAttempts: 2, delayMs: 1)),
        );

        try {
            $httpClient->get('GetPrekes');
            $this->fail('Expected ServerException');
        } catch (ServerException $e) {
            $this->assertSame(503, $e->getCode());
        }

        $this->assertCount(2, $this->history);
    }

    public function test_a_single_attempt_policy_throws_the_same_exception_as_no_policy(): void
    {
        $httpClient = $this->httpClient(
            [new Response(503)],
            $this->config(retry: RetryPolicy::noRetry()),
        );

        $this->expectException(ServerException::class);
        $this->expectExceptionCode(503);

        $httpClient->get('GetPrekes');
    }

    public function test_a_retry_policy_needs_at_least_one_attempt(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new RetryPolicy(maxAttempts: 0);
    }

    public function test_a_query_password_never_reaches_an_exception_message(): void
    {
        $httpClient = $this->httpClient([new Response(500)], $this->config());

        try {
            $httpClient->get('GetFvsUser', ['sUserName' => 'x', 'sPassword' => 'S3cret!']);
            $this->fail('Expected ServerException');
        } catch (ServerException $e) {
            $this->assertStringNotContainsString('S3cret', $e->getMessage());
            $this->assertStringContainsString('sPassword=***', $e->getMessage());
            $this->assertStringContainsString('GetFvsUser', $e->getMessage());
        }
    }

    public function test_a_query_password_never_reaches_the_retry_warning_log(): void
    {
        $logger = $this->spyLogger();
        $httpClient = $this->httpClient(
            [new Response(500), new Response(500)],
            $this->config(logger: $logger, retry: new RetryPolicy(maxAttempts: 2, delayMs: 1)),
        );

        try {
            $httpClient->get('GetFvsUser', ['sUserName' => 'x', 'sPassword' => 'S3cret!']);
        } catch (ServerException) {
        }

        $warnings = array_filter($logger->records, fn (array $r): bool => $r[0] === 'warning');

        $this->assertNotEmpty($warnings);
        $this->assertStringNotContainsString('S3cret', json_encode($logger->records));
    }

    public function test_a_failure_carries_the_status_and_a_body_snippet_when_the_body_is_not_json(): void
    {
        $httpClient = $this->httpClient([new Response(200, [], '"just a string"')]);

        try {
            $httpClient->get('GetPrekes');
            $this->fail('Expected FinvaldaException');
        } catch (FinvaldaException $e) {
            $this->assertStringContainsString('200', $e->getMessage());
            $this->assertStringContainsString('just a string', $e->getMessage());
        }
    }

    public function test_an_empty_xml_error_element_does_not_crash_operation_parsing(): void
    {
        $httpClient = $this->httpClient([
            new Response(200, [], '<R><AccessResult>Fail</AccessResult><sError/><nResult>5</nResult></R>'),
        ]);

        $result = $httpClient->postOperation('InsertNewItem', ['ItemClassName' => 'Fvs.Preke']);

        $this->assertFalse($result->success);
        $this->assertSame(5, $result->errorCode);
    }

    public function test_an_injected_client_without_a_base_uri_requests_the_configured_url(): void
    {
        $httpClient = $this->httpClient([$this->ok(['AccessResult' => 'Success'])]);
        $httpClient->record();

        $httpClient->get('GetPrekes', ['sKodas' => 'A']);

        $sent = (string) $this->history[0]['request']->getUri();

        $this->assertSame('https://example.com/svc/GetPrekes?sKodas=A', $sent);
        $this->assertSame($sent, $httpClient->lastRecording()?->url);
    }

    public function test_an_injected_client_gets_the_configured_timeout(): void
    {
        $httpClient = $this->httpClient([$this->ok(['AccessResult' => 'Success'])], $this->config(timeout: 7));

        $httpClient->get('GetPrekes');

        $this->assertSame(7, $this->history[0]['options']['timeout']);
    }

    public function test_http_options_reach_every_request(): void
    {
        $httpClient = $this->httpClient(
            [$this->ok(['AccessResult' => 'Success'])],
            $this->config(httpOptions: ['verify' => false, 'connect_timeout' => 3]),
        );

        $httpClient->get('GetPrekes');

        $this->assertFalse($this->history[0]['options']['verify']);
        $this->assertSame(3, $this->history[0]['options']['connect_timeout']);
    }

    public function test_the_logged_request_params_do_not_repeat_a_json_body(): void
    {
        $logger = $this->spyLogger();
        $httpClient = $this->httpClient([$this->ok()], $this->config(logger: $logger));

        $httpClient->postOperation('InsertDocument', ['sFileName' => 'a.pdf', 'sFileContent' => str_repeat('ab', 40_000)]);

        $context = $logger->records[0][2];

        $this->assertSame([], $context['params']);
        $this->assertArrayNotHasKey('has_body', $context);
        $this->assertLessThan(1_000, strlen(json_encode($context)));
    }

    public function test_request_and_response_log_lines_and_the_recording_share_a_request_id(): void
    {
        $logger = $this->spyLogger();
        $httpClient = $this->httpClient([$this->ok(['AccessResult' => 'Success'])], $this->config(logger: $logger));
        $httpClient->record();

        $httpClient->get('GetPrekes');

        [$request, $response] = array_column($logger->records, 2);

        $this->assertMatchesRegularExpression('/^[0-9a-f]{16}$/', $request['request_id']);
        $this->assertSame($request['request_id'], $response['request_id']);
        $this->assertSame($request['request_id'], $httpClient->lastRecording()?->requestId);
    }

    public function test_each_call_gets_its_own_request_id(): void
    {
        $logger = $this->spyLogger();
        $httpClient = $this->httpClient(
            [$this->ok(['AccessResult' => 'Success']), $this->ok(['AccessResult' => 'Success'])],
            $this->config(logger: $logger),
        );

        $httpClient->get('GetPrekes');
        $httpClient->get('GetPrekes');

        $this->assertNotSame($logger->records[0][2]['request_id'], $logger->records[2][2]['request_id']);
    }
}
