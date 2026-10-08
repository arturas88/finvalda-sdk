<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\DocumentEntityType;
use Finvalda\Exceptions\NetworkException;
use Finvalda\FinvaldaConfig;
use Finvalda\HttpClient;
use Finvalda\Resources\Documents;
use Finvalda\Retry\RetryPolicy;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Wire shapes follow docs/FVS_Webservice.md §3.80–3.83. The PURE examples are
 * captured requests; the writes go out as POST (the Pure service takes GET or
 * POST with the same parameter names) so the transport never retries them.
 */
class DocumentsTest extends TestCase
{
    use CreatesMockHttpClient;

    /**
     * @param  array<int, array<string, mixed>>  $history
     */
    private function documents(array &$history, ?GuzzleResponse $response = null): Documents
    {
        return new Documents($this->createHttpClient([
            $response ?? $this->jsonResponse([
                'AccessResult' => 'Success',
                'error' => '',
                'result' => ['errorText' => '', 'errorCode' => 0, 'accessResult' => 2],
            ]),
        ], $history));
    }

    /**
     * @return array<string, mixed>
     */
    private function requestBody(array $history): array
    {
        return json_decode((string) $history[0]['request']->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<string, string>
     */
    private function query(array $history): array
    {
        parse_str($history[0]['request']->getUri()->getQuery(), $query);

        return $query;
    }

    private function endpoint(array $history): string
    {
        return basename($history[0]['request']->getUri()->getPath());
    }

    public function test_upload_posts_the_file_under_in_params(): void
    {
        $history = [];

        $result = $this->documents($history)->upload('test00.txt', '4C6F72656D20697073756D');

        $this->assertTrue($result->success);
        $this->assertSame('POST', $history[0]['request']->getMethod());
        $this->assertSame('InsertDocument', $this->endpoint($history));
        $this->assertSame(
            ['inParams' => ['fileName' => 'test00.txt', 'content' => '4C6F72656D20697073756D']],
            $this->requestBody($history),
        );
    }

    public function test_upload_sends_the_optional_metadata_in_the_spec_shape(): void
    {
        $history = [];

        $this->documents($history)->upload(
            'test00.txt',
            '4C6F72656D20697073756D',
            description: 'fileDesc',
            registrationNumber: 'R-1',
            compositionDate: '2022-04-06',
            searchPhrase: 'phrase',
            info: ['infoA', 'infoB', 'infoC'],
            finUser: 'S',
        );

        $this->assertSame([
            'inParams' => [
                'fileName' => 'test00.txt',
                'fileDescription' => 'fileDesc',
                'regNr' => 'R-1',
                'compositionDate' => ['year' => 2022, 'month' => 4, 'day' => 6],
                'searchPhrase' => 'phrase',
                'info' => ['infoA', 'infoB', 'infoC'],
                'content' => '4C6F72656D20697073756D',
                'finUser' => 'S',
            ],
        ], $this->requestBody($history));
    }

    public function test_upload_file_hex_encodes_the_file(): void
    {
        $history = [];
        $path = tempnam(sys_get_temp_dir(), 'fvs-doc-');
        file_put_contents($path, 'Lorem ipsum');

        try {
            $this->documents($history)->uploadFile('a.txt', $path);
        } finally {
            unlink($path);
        }

        $this->assertSame('4c6f72656d20697073756d', $this->requestBody($history)['inParams']['content']);
    }

    public function test_an_error_code_in_the_result_is_a_failure(): void
    {
        $history = [];
        $response = $this->jsonResponse([
            'AccessResult' => 'Success',
            'error' => '',
            'result' => ['errorText' => 'nežinomas Finvaldos darbuotojas', 'errorCode' => 2, 'accessResult' => 2],
        ]);

        $result = $this->documents($history, $response)->upload('a.txt', '00', finUser: 'NOBODY');

        $this->assertFalse($result->success);
        $this->assertSame(2, $result->errorCode);
        $this->assertSame('nežinomas Finvaldos darbuotojas', $result->error);
    }

    public function test_an_error_code_under_the_spec_name_results_is_a_failure_too(): void
    {
        // The spec names InsertDocument's output `results`; the live server was
        // seen answering `result`. Either must fail closed.
        $history = [];
        $response = $this->jsonResponse([
            'AccessResult' => 'Success',
            'error' => '',
            'results' => ['errorText' => 'failas jau yra', 'errorCode' => 3],
        ]);

        $result = $this->documents($history, $response)->upload('a.txt', '00');

        $this->assertFalse($result->success);
        $this->assertSame(3, $result->errorCode);
    }

    public function test_a_failed_access_result_is_a_failure(): void
    {
        $history = [];
        $response = $this->jsonResponse(['AccessResult' => 'Fail', 'error' => 'boom']);

        $result = $this->documents($history, $response)->delete('a.txt');

        $this->assertFalse($result->success);
        $this->assertSame('boom', $result->error);
    }

    public function test_delete_posts_the_file_name(): void
    {
        $history = [];

        $result = $this->documents($history, $this->jsonResponse(['AccessResult' => 'Success', 'error' => '']))
            ->delete('a.txt');

        $this->assertTrue($result->success);
        $this->assertSame('POST', $history[0]['request']->getMethod());
        $this->assertSame('DeleteDocument', $this->endpoint($history));
        $this->assertSame(['fileName' => 'a.txt'], $this->requestBody($history));
    }

    public function test_attach_to_a_description_posts_the_flat_pure_parameters(): void
    {
        // The PURE example is a GET with these names as query parameters; the
        // Pure service takes the same names as a flat JSON body on POST, and a
        // write must be a POST so it is never retried.
        $history = [];

        $result = $this->documents($history)->attachTo(DocumentEntityType::Product, '010', 'a.txt', finUser: 'S2');

        $this->assertTrue($result->success);
        $this->assertSame('POST', $history[0]['request']->getMethod());
        $this->assertSame('AttachDocument', $this->endpoint($history));
        $this->assertSame(
            ['entityType' => 8, 'id1' => '010', 'documentId' => 'a.txt', 'finUser' => 'S2'],
            $this->requestBody($history),
        );
    }

    public function test_attach_to_an_operation_identifies_it_by_journal_and_number(): void
    {
        $history = [];

        $this->documents($history)->attachTo(DocumentEntityType::Sale, 'PARD', 'a.txt', 42);

        $this->assertSame(
            ['entityType' => 3, 'id1' => 'PARD', 'id2' => '42', 'documentId' => 'a.txt'],
            $this->requestBody($history),
        );
    }

    /**
     * @return array<string, array{\Closure(Documents): mixed}>
     */
    public static function writes(): array
    {
        return [
            'upload' => [fn (Documents $d) => $d->upload('a.txt', '00')],
            'delete' => [fn (Documents $d) => $d->delete('a.txt')],
            'attach' => [fn (Documents $d) => $d->attachTo(DocumentEntityType::Client, 'K1', 'a.txt')],
        ];
    }

    /**
     * @param  \Closure(Documents): mixed  $write
     */
    #[DataProvider('writes')]
    public function test_a_document_write_is_never_retried(\Closure $write): void
    {
        $history = [];
        $stack = HandlerStack::create(new MockHandler([
            new ConnectException('cURL error 28: Operation timed out', new Request('POST', 'x')),
            $this->jsonResponse(['AccessResult' => 'Success', 'error' => '']),
        ]));
        $stack->push(Middleware::history($history));
        $documents = new Documents(new HttpClient(new FinvaldaConfig(
            baseUrl: 'https://example.com',
            username: 'user',
            password: 'pass',
            retry: new RetryPolicy(maxAttempts: 3, delayMs: 1),
        ), new Client(['handler' => $stack])));

        try {
            $write($documents);
            $this->fail('Expected NetworkException');
        } catch (NetworkException) {
        }

        $this->assertCount(1, $history);
    }

    public function test_attached_reads_one_entity_with_the_pure_get(): void
    {
        $history = [];
        $response = $this->jsonResponse([
            'AccessResult' => 'Success',
            'error' => '',
            'result' => [
                'enitityDocs' => [[
                    'idString1' => '4ESAS',
                    'idString2' => '21',
                    'docs' => [['name' => 'a.txt', 'data' => '436364']],
                ]],
                'errorText' => '',
                'errorCode' => 0,
                'accessResult' => 2,
            ],
        ]);

        $response = $this->documents($history, $response)
            ->attachedTo(DocumentEntityType::SalesReservation, '4ESAS', 21);

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $history[0]['request']->getMethod());
        $this->assertSame('GetAttachedDocument', $this->endpoint($history));
        $this->assertSame(['entityType' => '75', 'id1' => '4ESAS', 'id2' => '21'], $this->query($history));
        $this->assertSame('a.txt', $response->raw['result']['enitityDocs'][0]['docs'][0]['name']);
    }
}
