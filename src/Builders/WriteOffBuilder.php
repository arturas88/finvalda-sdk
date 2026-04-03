<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for write-off/disposal operations (NurasymasDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->writeOff()
 *     ->date('2024-01-15')
 *     ->name('Monthly write-off')
 *     ->addItem('PRD001', quantity: 5, warehouse: 'MAIN', account: '6110')
 *     ->addItem('PRD002', quantity: 3, warehouse: 'MAIN', account: '6110')
 *     ->save('WRITEOFF');
 * ```
 */
final class WriteOffBuilder extends OperationBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::WriteOff;
    }

    protected function getHeaderKey(): string
    {
        return 'NurasymasDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'NurasymasDokDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        // Write-offs don't have service lines
        return 'NurasymasDokPaslaugaDetEil';
    }

    // --- Write-off-specific methods ---

    /**
     * Set the operation name/title.
     */
    public function name(string $name): self
    {
        $this->header['sPavadinimas'] = $name;

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
     * Set the employee name.
     */
    public function employee(string $name): self
    {
        $this->header['sDarbuotojas'] = $name;

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
     * Add a write-off item line.
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addItem(
        string $code,
        float $quantity,
        ?string $warehouse = null,
        ?string $account = null,
        array $additionalData = [],
    ): self {
        $line = array_merge([
            'sKodas' => $code,
            'nKiekis' => $quantity,
        ], $additionalData);

        if ($warehouse !== null) {
            $line['sSandelis'] = $warehouse;
        }

        if ($account !== null) {
            $line['sSaskaita'] = $account;
        }

        $this->productLines[] = $line;

        return $this;
    }
}
