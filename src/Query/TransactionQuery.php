<?php

declare(strict_types=1);

namespace Finvalda\Query;

use DateTimeInterface;
use Finvalda\Filters\TransactionFilter;

/**
 * Fluent query builder for transaction queries.
 *
 * Usage:
 * ```php
 * $query = TransactionQuery::create()
 *     ->journal('PARD')
 *     ->series('AA')
 *     ->dateRange('2024-01-01', '2024-12-31')
 *     ->modifiedSince('2024-06-01');
 *
 * $results = $finvalda->transactions()->sales($query->toFilter());
 * ```
 */
final class TransactionQuery extends QueryBuilder
{
    public static function create(): self
    {
        return new self();
    }

    /**
     * Filter by journal code.
     */
    public function journal(string $code): self
    {
        return $this->set('sJournal', $code);
    }

    /**
     * Filter by operation number.
     */
    public function operationNumber(int $number): self
    {
        return $this->set('nOpNumber', $number);
    }

    /**
     * Filter by document series.
     */
    public function series(string $series): self
    {
        return $this->set('sSeries', $series);
    }

    /**
     * Filter by order/document number.
     */
    public function orderNumber(string $number): self
    {
        return $this->set('sOrderNumber', $number);
    }

    /**
     * Filter by journal group.
     */
    public function journalGroup(string $group): self
    {
        return $this->set('sJournalGroup', $group);
    }

    /**
     * Filter by operation date range.
     */
    public function dateRange(
        DateTimeInterface|string|null $from,
        DateTimeInterface|string|null $to,
    ): self {
        $this->setDate('tOpDateFrom', $from);
        $this->setDate('tOpDateTill', $to);

        return $this;
    }

    /**
     * Filter by operation date from.
     */
    public function dateFrom(DateTimeInterface|string $date): self
    {
        return $this->setDate('tOpDateFrom', $date);
    }

    /**
     * Filter by operation date to.
     */
    public function dateTo(DateTimeInterface|string $date): self
    {
        return $this->setDate('tOpDateTill', $date);
    }

    /**
     * Filter by modification date.
     */
    public function modifiedSince(DateTimeInterface|string $date): self
    {
        return $this->setDate('tDateEdited', $date);
    }

    /**
     * Convert to TransactionFilter for use with existing resource methods.
     */
    public function toFilter(): TransactionFilter
    {
        $params = $this->build();

        return new TransactionFilter(
            journal: $params['sJournal'] ?? null,
            opNumber: $params['nOpNumber'] ?? null,
            series: $params['sSeries'] ?? null,
            orderNumber: $params['sOrderNumber'] ?? null,
            journalGroup: $params['sJournalGroup'] ?? null,
            dateFrom: $params['tOpDateFrom'] ?? null,
            dateTo: $params['tOpDateTill'] ?? null,
            modifiedSince: $params['tDateEdited'] ?? null,
        );
    }
}
