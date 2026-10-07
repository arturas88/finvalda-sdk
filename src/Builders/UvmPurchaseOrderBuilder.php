<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for UVM purchase order operations (UVMPirkUzsDok).
 *
 * UVMPirkUzsDok shares the PirkDok header table and the PirkDok detail elements.
 *
 * Usage:
 * ```php
 * $result = $finvalda->uvmPurchaseOrder()
 *     ->client('SUP001')
 *     ->date('2024-01-15')
 *     ->documentNumber('UZS-0001')
 *     ->currency('EUR')
 *     ->addProduct('PRD001', quantity: 24, amount: 84.00, warehouse: 'CENTR.')
 *     ->save('ORDER');
 * ```
 */
final class UvmPurchaseOrderBuilder extends PurchaseOperationBuilder
{
    protected function fullClass(): OperationClass
    {
        return OperationClass::UvmPurchaseOrder;
    }

    protected function shortClass(): OperationClass
    {
        return OperationClass::UvmPurchaseOrderShort;
    }
}
