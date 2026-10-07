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
use Finvalda\Builders\Concerns\SetsName;
use Finvalda\Builders\Concerns\SetsNote;
use Finvalda\Builders\Concerns\SetsObjects;
use Finvalda\Enums\DocumentType;
use Finvalda\Enums\OperationClass;
use Finvalda\Exceptions\ValidationException;

/**
 * Shared shape of the purchase family: PirkDok, PirkUzsDok, PirkGrazDok and
 * UVMPirkUzsDok share one header table and one set of detail elements
 * (PirkDokPrekeDetEil / PirkDokPaslaugaDetEil), and each has a Trumpas* variant.
 */
abstract class PurchaseOperationBuilder extends OperationBuilder
{
    use HasDefaultWarehouse;
    use SetsClient;
    use SetsCurrency;
    use SetsDocumentNumber;
    use SetsEmployee;
    use SetsLocked;
    use SetsMarked;
    use SetsName;
    use SetsNote;
    use SetsObjects;

    /**
     * The only header fields a TrumpasPirk* envelope accepts. The spec table
     * omits tData, but every operation requires a date.
     */
    private const SHORT_HEADER_FIELDS = [
        'sValiuta', 'sKlientas', 'sKlientImonesKodas', 'sSerija', 'sDokumentas', 'sDokRusis', 'tData',
    ];

    /** Sales-only line fields: purchase detail lines have no unit price or sPapInf. */
    private const SALES_ONLY_LINE_FIELDS = ['dSumaVntV', 'dSumaVntL', 'dSumaVntPV', 'dSumaVntPL', 'sPapInf'];

    protected bool $short = false;

    abstract protected function fullClass(): OperationClass;

    abstract protected function shortClass(): OperationClass;

    public function getOperationClass(): OperationClass
    {
        return $this->short ? $this->shortClass() : $this->fullClass();
    }

    protected function getProductLinesKey(): string
    {
        return 'PirkDokPrekeDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        return 'PirkDokPaslaugaDetEil';
    }

    /**
     * Use the short/simplified variant (Trumpas*). Its header takes only client,
     * date, series, document, currency and document type; build() rejects
     * anything else.
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
        } elseif (array_key_exists('sSerija', $this->header)) {
            throw new ValidationException(
                "{$this->getHeaderKey()} has no series field (sSerija); series() applies to short() purchases only"
            );
        }

        $this->rejectLineFields(
            $this->productLines,
            'PirkDokPrekeDetEil',
            self::SALES_ONLY_LINE_FIELDS,
            'purchase lines carry amounts, not a unit price, and no sPapInf',
        );

        $this->rejectLineFields(
            $this->serviceLines,
            'PirkDokPaslaugaDetEil',
            [...self::SALES_ONLY_LINE_FIELDS, 'sPavadinimas'],
            'purchase service lines carry amounts, not a unit price; use sPastaba for text',
        );

        $this->productLines = $this->withDefaultWarehouse($this->productLines);

        return parent::build();
    }

    /**
     * Set the document series (sSerija). Short (Trumpas*) purchases only — the
     * full purchase header has no series field, and build() says so.
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
