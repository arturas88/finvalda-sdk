<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Builders\Concerns\HasAdditionalCostCodes;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for purchase operations (PirkDok).
 *
 * The supplier's invoice number goes in documentNumber() (sDokumentas); the
 * spec has no separate supplier-invoice field.
 *
 * Usage:
 * ```php
 * $result = $finvalda->purchase()
 *     ->client('SUP001')
 *     ->date('2024-01-15')
 *     ->documentNumber('INV-2024-001')
 *     ->currency('EUR')
 *     ->warehouse('MAIN')
 *     ->addProduct('PRD001', quantity: 100, amount: 999.00)
 *     ->save('STANDARD');
 * ```
 */
final class PurchaseBuilder extends PurchaseOperationBuilder
{
    use HasAdditionalCostCodes;

    /**
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $this->assertAdditionalCostCodesAllowed($this->getHeaderKey());

        return parent::build();
    }

    protected function allowsAdditionalCostCodes(): bool
    {
        return ! $this->short;
    }

    protected function fullClass(): OperationClass
    {
        return OperationClass::Purchase;
    }

    protected function shortClass(): OperationClass
    {
        return OperationClass::PurchaseShort;
    }
}
