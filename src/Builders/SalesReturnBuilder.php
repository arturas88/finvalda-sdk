<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for sales return operations (PardGrazDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->salesReturn()
 *     ->short()
 *     ->client('CLI001')
 *     ->date('2024-01-20')
 *     ->documentNumber('GRAZ-0001')
 *     ->currency('EUR')
 *     ->warehouse('MAIN')
 *     ->addProduct('PRD001', quantity: 2, amount: 39.98)
 *     ->save('RETURN');
 * ```
 *
 * Note: in live testing the full PardGrazDok variant was rejected with error
 * 2012 ("Xml string is incomplete") even with a spec-correct payload, while
 * the identical fields via ->short() (TrumpasPardGrazDok) succeeded. If the
 * full variant fails with 2012, use ->short().
 *
 * The spec has no field linking a return to the original sale; the former
 * originalDocument()/reason() setters wrote invented fields and were removed.
 */
final class SalesReturnBuilder extends SalesOperationBuilder
{
    protected function fullClass(): OperationClass
    {
        return OperationClass::SalesReturn;
    }

    protected function shortClass(): OperationClass
    {
        return OperationClass::SalesReturnShort;
    }
}
