<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\DocumentEntityType;
use Finvalda\Resources\Documents;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PHPUnit\Framework\TestCase;

/**
 * Wire shapes follow the PURE examples in docs/FVS_Webservice.md §3.80–3.83,
 * which are captured requests, not hand-written ones.
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

    public function test_attach_to_a_description_sends_the_flat_pure_query(): void
    {
        $history = [];

        $result = $this->documents($history)->attach(DocumentEntityType::Product, '010', 'a.txt', finUser: 'S2');

        $this->assertTrue($result->success);
        $this->assertSame('GET', $history[0]['request']->getMethod());
        $this->assertSame('AttachDocument', $this->endpoint($history));
        $this->assertSame(
            ['entityType' => '8', 'id1' => '010', 'documentId' => 'a.txt', 'finUser' => 'S2'],
            $this->query($history),
        );
    }

    public function test_attach_to_an_operation_identifies_it_by_journal_and_number(): void
    {
        $history = [];

        $this->documents($history)->attach(DocumentEntityType::Sale, 'PARD', 'a.txt', 42);

        $this->assertSame(
            ['entityType' => '3', 'id1' => 'PARD', 'id2' => '42', 'documentId' => 'a.txt'],
            $this->query($history),
        );
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
            ->attached(DocumentEntityType::SalesReservation, '4ESAS', 21);

        $this->assertTrue($response->successful());
        $this->assertSame('GET', $history[0]['request']->getMethod());
        $this->assertSame('GetAttachedDocument', $this->endpoint($history));
        $this->assertSame(['entityType' => '75', 'id1' => '4ESAS', 'id2' => '21'], $this->query($history));
        $this->assertSame('a.txt', $response->raw['result']['enitityDocs'][0]['docs'][0]['name']);
    }
}
