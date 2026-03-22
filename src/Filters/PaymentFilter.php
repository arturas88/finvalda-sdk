<?php

declare(strict_types=1);

namespace Finvalda\Filters;

/**
 * Additional filters for payment-related transaction queries.
 *
 * Used by inflows, disbursements, advance payments, and clearing offset queries
 * to filter by the document that was paid for.
 */
final class PaymentFilter
{
    public function __construct(
        /** Journal code of the document being paid for. */
        public readonly ?string $payedForDocJournal = null,

        /** Operation number of the document being paid for. */
        public readonly ?int $payedForDocNumber = null,

        /** Series of the document being paid for. */
        public readonly ?string $payedForDocSeries = null,

        /** Order number of the document being paid for. */
        public readonly ?string $payedForDocOrderNumber = null,
    ) {}

    /**
     * Convert to API query parameters.
     */
    public function toParams(): array
    {
        return [
            'sPayedForDocJournal' => $this->payedForDocJournal,
            'nPayedForDocNumber' => $this->payedForDocNumber,
            'sPayedForDocSeries' => $this->payedForDocSeries,
            'sPayedForDocOrderNumber' => $this->payedForDocOrderNumber,
        ];
    }
}
