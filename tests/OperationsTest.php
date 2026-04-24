<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\OpClass;
use Finvalda\Resources\Operations;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use JsonException;
use PHPUnit\Framework\TestCase;

class OperationsTest extends TestCase
{
    use CreatesMockHttpClient;

    public function test_get_wraps_filters_in_json_encoded_opReadParams_query(): void
    {
        $history = [];
        $operations = new Operations($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $operations->get(OpClass::Sales, [
            'filter' => ['Journal' => 'PARD', 'OpDateFrom' => '2024-01-01'],
            'fullOp' => false,
        ]);

        parse_str($history[0]['request']->getUri()->getQuery(), $query);
        $this->assertArrayHasKey('opReadParams', $query);
        $this->assertSame([
            'OpClass' => 'Sales',
            'filter' => ['Journal' => 'PARD', 'OpDateFrom' => '2024-01-01'],
            'fullOp' => false,
        ], json_decode($query['opReadParams'], true, flags: JSON_THROW_ON_ERROR));
    }

    public function test_change_journal_decodes_json_string_input(): void
    {
        $history = [];
        $operations = new Operations($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'nResult' => 0]),
        ], $history));

        $operations->changeJournal('{"sJournal":"PARD","nOpNumber":42,"sJournalNew":"PARD2"}');

        $body = json_decode((string) $history[0]['request']->getBody(), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame([
            'sJournal' => 'PARD',
            'nOpNumber' => 42,
            'sJournalNew' => 'PARD2',
        ], $body);
    }

    public function test_change_journal_throws_on_invalid_json(): void
    {
        $operations = new Operations($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'nResult' => 0]),
        ]));

        $this->expectException(JsonException::class);

        $operations->changeJournal('not-valid-json');
    }

    public function test_copy_wraps_decoded_input_in_input_envelope(): void
    {
        $history = [];
        $operations = new Operations($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'nResult' => 0]),
        ], $history));

        $operations->copy(['sJournal' => 'PARD', 'nOpNumber' => 7]);

        $body = json_decode((string) $history[0]['request']->getBody(), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame(['input' => ['sJournal' => 'PARD', 'nOpNumber' => 7]], $body);
    }

    public function test_copy_throws_on_invalid_json_string(): void
    {
        $operations = new Operations($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'nResult' => 0]),
        ]));

        $this->expectException(JsonException::class);

        $operations->copy('{broken');
    }
}
