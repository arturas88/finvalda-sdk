<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use DateTimeInterface;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for inventory count operations (Inventorizacija).
 *
 * Inventory counts have a flat structure with a mode flag and item list.
 * Mode 0 = create new inventory count, mode 1 = append to existing.
 *
 * Usage:
 * ```php
 * $result = $finvalda->inventoryCount()
 *     ->journal('INVENT')
 *     ->warehouse('01')
 *     ->date('2024-03-03')
 *     ->addItem('B.BENZINAS', quantity: 15.45, account: '1275')
 *     ->addItem('B.DYZELINAS', quantity: 20.00, account: '1275')
 *     ->save('INVENTORY');
 * ```
 */
final class InventoryCountBuilder extends OperationBuilder
{
    /** @var array<int, array<string, mixed>> */
    protected array $items = [];

    protected int $mode = 0;

    public function getOperationClass(): OperationClass
    {
        return OperationClass::InventoryCount;
    }

    protected function getHeaderKey(): string
    {
        return 'Inventorizacija';
    }

    protected function getProductLinesKey(): string
    {
        return 'Inventorizacija';
    }

    protected function getServiceLinesKey(): string
    {
        return 'Inventorizacija';
    }

    /**
     * Build the complete operation data array.
     *
     * Each item gets the shared header fields (journal, warehouse, date) merged in.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $data = ['mode' => $this->mode];

        $items = [];
        foreach ($this->items as $item) {
            $items[] = array_merge($this->header, $item);
        }

        if (! empty($items)) {
            $data['Inventorizacija'] = $items;
        }

        return $data;
    }

    // --- Inventory count-specific methods ---

    /**
     * Set the inventory count mode.
     *
     * @param  int  $mode  0 = create new, 1 = append to existing
     */
    public function mode(int $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Set the journal code (shared across all items).
     */
    public function journal(string $journal): self
    {
        $this->header['sZurnalas'] = $journal;

        return $this;
    }

    /**
     * Set the default account code (shared across all items).
     */
    public function account(string $account): self
    {
        $this->header['sSaskaita'] = $account;

        return $this;
    }

    /**
     * Add an inventory count item.
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addItem(
        string $code,
        float $quantity,
        ?string $warehouse = null,
        ?string $account = null,
        DateTimeInterface|string|null $date = null,
        array $additionalData = [],
    ): self {
        $line = array_merge([
            'sKodas' => $code,
            'dKiekis' => $quantity,
        ], $additionalData);

        if ($warehouse !== null) {
            $line['sSandelis'] = $warehouse;
        }

        if ($account !== null) {
            $line['sSaskaita'] = $account;
        }

        if ($date !== null) {
            $line['tData'] = $this->formatDate($date);
        }

        $this->items[] = $line;

        return $this;
    }
}
