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
 *     ->warehouse('MAIN')
 *     ->addItem('PRD001', quantity: 5, account: '6110')
 *     ->addItem('PRD002', quantity: 3, account: '6110')
 *     ->save('WRITEOFF');
 * ```
 */
final class WriteOffBuilder extends StockAdjustmentBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::WriteOff;
    }

    /**
     * Add a write-off item line.
     *
     * @param  array<string, mixed>  $additionalData  Further NurasymasDokDetEil fields
     */
    public function addItem(
        string $code,
        float $quantity,
        ?string $warehouse = null,
        ?string $account = null,
        array $additionalData = [],
    ): self {
        return $this->addStockLine($code, $quantity, $warehouse, $account, $additionalData);
    }
}
