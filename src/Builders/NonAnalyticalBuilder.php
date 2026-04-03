<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for non-analytical accounting operations (KtNeanalitDok).
 *
 * Non-analytical operations create general ledger entries with debit/credit amounts.
 *
 * Usage:
 * ```php
 * $result = $finvalda->nonAnalytical()
 *     ->date('2024-01-15')
 *     ->currency('EUR')
 *     ->documentNumber('TEST1')
 *     ->description1('Depreciation entry')
 *     ->addEntry('6110', 'Equipment depreciation', debitLocal: 500.00, creditLocal: 0)
 *     ->addEntry('1240', 'Accumulated depreciation', debitLocal: 0, creditLocal: 500.00)
 *     ->save('JOURNAL');
 * ```
 */
final class NonAnalyticalBuilder extends OperationBuilder
{
    /** @var array<int, array<string, mixed>> */
    protected array $entries = [];

    public function getOperationClass(): OperationClass
    {
        return OperationClass::NonAnalytical;
    }

    protected function getHeaderKey(): string
    {
        return 'KtNeanalitDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'KtNeanalitDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        // Non-analytical operations don't have service lines
        return 'KtNeanalitPaslaugaDetEil';
    }

    /**
     * Build the complete operation data array.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $data = [];

        if (! empty($this->header)) {
            $data[$this->getHeaderKey()] = $this->header;
        }

        if (! empty($this->entries)) {
            $data['KtNeanalitDetEil'] = $this->entries;
        }

        return $data;
    }

    // --- Non-analytical-specific methods ---

    /**
     * Set the first description line.
     */
    public function description1(string $description): self
    {
        $this->header['sPavadinimas1'] = $description;

        return $this;
    }

    /**
     * Set the second description line.
     */
    public function description2(string $description): self
    {
        $this->header['sPavadinimas2'] = $description;

        return $this;
    }

    /**
     * Set a note/comment.
     */
    public function note(string $note): self
    {
        $this->header['sPastaba'] = $note;

        return $this;
    }

    /**
     * Set the marked/flagged status.
     */
    public function marked(bool $marked = true): self
    {
        $this->header['nPozymis'] = $marked ? 1 : 0;

        return $this;
    }

    /**
     * Add an accounting entry line.
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addEntry(
        string $accountCode,
        string $description,
        float $debitLocal,
        float $creditLocal,
        ?float $debitCurrency = null,
        ?float $creditCurrency = null,
        array $additionalData = [],
    ): self {
        $line = array_merge([
            'sKodas' => $accountCode,
            'sPavadinimas' => $description,
            'dDebetasL' => $debitLocal,
            'dKreditasL' => $creditLocal,
        ], $additionalData);

        if ($debitCurrency !== null) {
            $line['dDebetasV'] = $debitCurrency;
        }

        if ($creditCurrency !== null) {
            $line['dKreditasV'] = $creditCurrency;
        }

        $this->entries[] = $line;

        return $this;
    }
}
