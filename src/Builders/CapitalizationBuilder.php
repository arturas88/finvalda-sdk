<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for capitalization/receiving operations (PajamavimasDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->capitalization()
 *     ->date('2024-01-15')
 *     ->name('Inventory receiving')
 *     ->addItem('PRD001', quantity: 10, amount: 199.90, warehouse: 'MAIN', account: '2010')
 *     ->save('CAPITALIZE');
 * ```
 */
final class CapitalizationBuilder extends OperationBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::Capitalization;
    }

    protected function getHeaderKey(): string
    {
        return 'PajamavimasDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'PajamavimasDokDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        // Capitalizations don't have service lines
        return 'PajamavimasDokPaslaugaDetEil';
    }

    // --- Capitalization-specific methods ---

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
     * Add a capitalization item line.
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addItem(
        string $code,
        float $quantity,
        float $amount,
        ?string $warehouse = null,
        ?string $account = null,
        array $additionalData = [],
    ): self {
        $line = array_merge([
            'sKodas' => $code,
            'nKiekis' => $quantity,
            'dSuma' => $amount,
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
