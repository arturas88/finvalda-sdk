<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use DateTimeInterface;
use Finvalda\Builders\Concerns\HasDefaultWarehouse;
use Finvalda\Builders\Concerns\SetsClient;
use Finvalda\Builders\Concerns\SetsCurrency;
use Finvalda\Builders\Concerns\SetsDocumentNumber;
use Finvalda\Builders\Concerns\SetsEmployee;
use Finvalda\Builders\Concerns\SetsLocked;
use Finvalda\Builders\Concerns\SetsMarked;
use Finvalda\Builders\Concerns\SetsNote;
use Finvalda\Builders\Concerns\SetsObjects;
use Finvalda\Enums\DocumentType;
use Finvalda\Enums\OperationClass;
use Finvalda\Exceptions\ValidationException;

/**
 * Shared shape of the sales family: PardDok, PardRezDok, PardGrazDok and
 * UVMPardRezDok share one header table and one set of detail elements
 * (PardDokPrekeDetEil / PardDokPaslaugaDetEil), and each has a Trumpas* variant.
 */
abstract class SalesOperationBuilder extends OperationBuilder
{
    use HasDefaultWarehouse;
    use SetsClient;
    use SetsCurrency;
    use SetsDocumentNumber;
    use SetsEmployee;
    use SetsLocked;
    use SetsMarked;
    use SetsNote;
    use SetsObjects;

    /** The only header fields a TrumpasPard* envelope accepts. */
    private const SHORT_HEADER_FIELDS = [
        'sKlientas', 'sKlientImonesKodas', 'tData', 'sSerija', 'sDokumentas', 'sValiuta',
        'tIvykdymoData', 'sDokRusis',
    ];

    /** Purchase-only line fields ("Tik PirkDokPrekeDetEil"). */
    private const PURCHASE_ONLY_LINE_FIELDS = [
        'dPapIsldSumaV1', 'dPapIsldSumaL1', 'dPapIsldSumaV2', 'dPapIsldSumaL2',
        'dPapIsldSumaV3', 'dPapIsldSumaL3', 'dPapIsldSumaV4', 'dPapIsldSumaL4',
    ];

    protected bool $short = false;

    abstract protected function fullClass(): OperationClass;

    abstract protected function shortClass(): OperationClass;

    public function getOperationClass(): OperationClass
    {
        return $this->short ? $this->shortClass() : $this->fullClass();
    }

    protected function getProductLinesKey(): string
    {
        return 'PardDokPrekeDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        return 'PardDokPaslaugaDetEil';
    }

    /**
     * Use the short/simplified variant (Trumpas*). Its header takes only client,
     * date, series, document, currency, fulfillment date and document type;
     * build() rejects anything else.
     */
    public function short(bool $short = true): static
    {
        $this->short = $short;

        return $this;
    }

    /**
     * @return array<string, mixed>
     *
     * @throws ValidationException  On a field the envelope does not define.
     */
    public function build(): array
    {
        if ($this->short) {
            $this->assertHeaderOnly(self::SHORT_HEADER_FIELDS);
        }

        $this->rejectLineFields(
            $this->productLines,
            'PardDokPrekeDetEil',
            self::PURCHASE_ONLY_LINE_FIELDS,
            'additional costs are purchase-only',
        );

        $this->requireAmountWithUnitPrice($this->productLines, $this->getProductLinesKey());
        $this->requireAmountWithUnitPrice($this->serviceLines, $this->getServiceLinesKey());

        $this->assertDueDateNotBeforeDocumentDate();

        return $this->withDefaultWarehouseOnProductLines(parent::build());
    }

    /**
     * The server takes a line's amount from dSumaV only: a line carrying just the
     * unit price (dSumaVntV) is accepted and booked at 0 (verified on a live
     * server, 2026-10-07). Refuse it rather than book a free sale.
     *
     * @param  array<int, array<string, mixed>>  $lines
     *
     * @throws ValidationException
     */
    private function requireAmountWithUnitPrice(array $lines, string $element): void
    {
        foreach ($lines as $line) {
            if (isset($line['dSumaVntV']) && ! isset($line['dSumaV'])) {
                throw new ValidationException(
                    "{$element} line {$line['sKodas']}: a unit price (dSumaVntV) alone is booked as amount 0; "
                    . 'also set the line amount (dSumaV) with amount() / the $amount argument'
                );
            }
        }
    }

    /**
     * Set the document series (sSerija).
     */
    public function series(string $series): static
    {
        $this->header['sSerija'] = $series;

        return $this;
    }

    /**
     * Set the document type/kind (sDokRusis).
     *
     * Accepts a DocumentType enum case or a raw 2-char code (S, SF, D, DS, K, KS, KT, VS, VD, VK).
     */
    public function documentType(DocumentType|string $type): static
    {
        $this->header['sDokRusis'] = $type instanceof DocumentType ? $type->value : $type;

        return $this;
    }

    /**
     * Set the fulfillment/execution date (tIvykdymoData).
     */
    public function fulfillmentDate(DateTimeInterface|string $date): static
    {
        $this->header['tIvykdymoData'] = $this->formatDate($date);

        return $this;
    }

    /**
     * Set the payment due date (tMokejimoData).
     */
    public function dueDate(DateTimeInterface|string $date): static
    {
        $this->header['tMokejimoData'] = $this->formatDate($date);

        return $this;
    }

    /**
     * Set the document discount percentage (dNuolaida).
     */
    public function discount(float $percent): static
    {
        $this->header['dNuolaida'] = $percent;

        return $this;
    }

    /**
     * Set the rounding amount for cent rounding (dGrApvalinimoSuma).
     */
    public function roundingAmount(float $amount): static
    {
        $this->header['dGrApvalinimoSuma'] = $amount;

        return $this;
    }

    /**
     * Set whether to export to iVAZ (nIVAZ).
     */
    public function exportToIvaz(bool $export = true): static
    {
        $this->header['nIVAZ'] = $export ? 1 : 0;

        return $this;
    }
}
