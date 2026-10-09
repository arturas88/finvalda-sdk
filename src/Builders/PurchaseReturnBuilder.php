<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for purchase return operations (PirkGrazDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->purchaseReturn()
 *     ->client('SUP001')
 *     ->date('2024-01-20')
 *     ->documentNumber('GRAZ-0001')
 *     ->currency('EUR')
 *     ->warehouse('MAIN')
 *     ->addProduct('PRD001', quantity: 10, amount: 99.90)
 *     ->save('RETURN');
 * ```
 *
 * The spec has no field linking a return to the original purchase; the former
 * originalDocument()/reason() setters wrote invented fields and were removed.
 */
final class PurchaseReturnBuilder extends PurchaseOperationBuilder
{
    protected function fullClass(): OperationClass
    {
        return OperationClass::PurchaseReturn;
    }

    protected function shortClass(): OperationClass
    {
        return OperationClass::PurchaseReturnShort;
    }
}
