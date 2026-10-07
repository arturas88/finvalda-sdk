<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Builders\Concerns\HasAdditionalCostCodes;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for purchase order operations (PirkUzsDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->purchaseOrder()
 *     ->client('SUP001')
 *     ->date('2024-01-15')
 *     ->documentNumber('UZS-0001')
 *     ->currency('EUR')
 *     ->addProduct('PRD001', quantity: 24, amount: 84.00, warehouse: 'CENTR.')
 *     ->save('ORDER');
 * ```
 */
final class PurchaseOrderBuilder extends PurchaseOperationBuilder
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
        return OperationClass::PurchaseOrder;
    }

    protected function shortClass(): OperationClass
    {
        return OperationClass::PurchaseOrderShort;
    }
}
