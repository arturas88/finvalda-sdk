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
 *     ->name('Stock receiving')
 *     ->warehouse('MAIN')
 *     ->addItem('PRD001', quantity: 10, amount: 199.90, account: '2010')
 *     ->save('CAPITALIZATION');
 * ```
 */
final class CapitalizationBuilder extends StockAdjustmentBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::Capitalization;
    }

    /**
     * Add a capitalization item line.
     *
     * @param  array<string, mixed>  $additionalData  Further PajamavimasDokDetEil fields
     */
    public function addItem(
        string $code,
        float $quantity,
        float $amount,
        ?string $warehouse = null,
        ?string $account = null,
        array $additionalData = [],
    ): self {
        return $this->addStockLine($code, $quantity, $warehouse, $account, ['dSuma' => $amount] + $additionalData);
    }
}
