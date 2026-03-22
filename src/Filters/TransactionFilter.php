<?php

declare(strict_types=1);

namespace Finvalda\Filters;

use DateTimeInterface;

/**
 * Common filter for financial transaction detail queries.
 *
 * Used by all Transactions resource methods (sales, purchases, inflows, etc.)
 * to provide a consistent set of filters for operation lookup.
 */
final class TransactionFilter
{
    public function __construct(
        /** Journal code (e.g., 'PARD', 'PIRK'). */
        public readonly ?string $journal = null,

        /** Operation number within the journal. */
        public readonly ?int $opNumber = null,

        /** Document series code (e.g., 'AA', 'BB'). */
        public readonly ?string $series = null,

        /** Order/document number (e.g., 'SF-001'). */
        public readonly ?string $orderNumber = null,

        /** Journal group code for filtering by group. */
        public readonly ?string $journalGroup = null,

        /** Operation date range start (Y-m-d or DateTimeInterface). */
        public readonly DateTimeInterface|string|null $dateFrom = null,

        /** Operation date range end (Y-m-d or DateTimeInterface). */
        public readonly DateTimeInterface|string|null $dateTo = null,

        /** Return only records modified since this date (Y-m-d or DateTimeInterface). */
        public readonly DateTimeInterface|string|null $modifiedSince = null,
    ) {}

    /**
     * Convert to API query parameters.
     */
    public function toParams(): array
    {
        return [
            'sJournal' => $this->journal,
            'nOpNumber' => $this->opNumber,
            'sSeries' => $this->series,
            'sOrderNumber' => $this->orderNumber,
            'sJournalGroup' => $this->journalGroup,
            'tOpDateFrom' => $this->formatDate($this->dateFrom),
            'tOpDateTill' => $this->formatDate($this->dateTo),
            'tDateEdited' => $this->formatDate($this->modifiedSince),
        ];
    }

    private function formatDate(DateTimeInterface|string|null $date): ?string
    {
        if ($date instanceof DateTimeInterface) {
            return $date->format('Y-m-d');
        }

        return $date;
    }
}
