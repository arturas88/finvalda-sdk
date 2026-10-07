<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for UVM sales reservation operations (UVMPardRezDok).
 *
 * UVMPardRezDok shares the PardDok header table and the PardDok detail elements.
 *
 * Usage:
 * ```php
 * $result = $finvalda->uvmSalesReservation()
 *     ->client('HTNT')
 *     ->date('2026-04-03')
 *     ->documentNumber('30608')
 *     ->fulfillmentDate('2026-04-03')
 *     ->currency('EUR')
 *     ->object1('SERVISAS')
 *     ->object2('TS 444')
 *     ->object4('3186192')
 *     ->service(ServiceLine::make('5054', 1)->amount(0)->description('Koja užspausta'))
 *     ->save('WORKSHOP');
 * ```
 */
final class UvmSalesReservationBuilder extends SalesOperationBuilder
{
    protected function fullClass(): OperationClass
    {
        return OperationClass::UvmSalesReservation;
    }

    protected function shortClass(): OperationClass
    {
        return OperationClass::UvmSalesReservationShort;
    }
}
