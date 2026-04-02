<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use DateTime;
use DateTimeImmutable;
use Finvalda\Filters\TransactionFilter;
use PHPUnit\Framework\TestCase;

class TransactionFilterTest extends TestCase
{
    public function test_it_converts_to_params_with_all_values(): void
    {
        $filter = new TransactionFilter(
            journal: 'PARD',
            opNumber: 123,
            series: 'AA',
            orderNumber: 'SF-001',
            journalGroup: 'SALES',
            dateFrom: '2024-01-01',
            dateTo: '2024-12-31',
            modifiedSince: '2024-06-15',
        );

        $params = $filter->toParams();

        $this->assertSame('PARD', $params['sJournal']);
        $this->assertSame(123, $params['nOpNumber']);
        $this->assertSame('AA', $params['sSeries']);
        $this->assertSame('SF-001', $params['sOrderNumber']);
        $this->assertSame('SALES', $params['sJournalGroup']);
        $this->assertSame('2024-01-01', $params['tOpDateFrom']);
        $this->assertSame('2024-12-31', $params['tOpDateTill']);
        $this->assertSame('2024-06-15', $params['tDateEdited']);
    }

    public function test_it_converts_datetime_objects_to_strings(): void
    {
        $filter = new TransactionFilter(
            dateFrom: new DateTime('2024-03-15'),
            dateTo: new DateTimeImmutable('2024-06-30'),
        );

        $params = $filter->toParams();

        $this->assertSame('2024-03-15', $params['tOpDateFrom']);
        $this->assertSame('2024-06-30', $params['tOpDateTill']);
    }

    public function test_it_returns_nulls_for_empty_filter(): void
    {
        $filter = new TransactionFilter();

        $params = $filter->toParams();

        $this->assertNull($params['sJournal']);
        $this->assertNull($params['nOpNumber']);
        $this->assertNull($params['sSeries']);
        $this->assertNull($params['sOrderNumber']);
        $this->assertNull($params['sJournalGroup']);
        $this->assertNull($params['tOpDateFrom']);
        $this->assertNull($params['tOpDateTill']);
        $this->assertNull($params['tDateEdited']);
    }
}
