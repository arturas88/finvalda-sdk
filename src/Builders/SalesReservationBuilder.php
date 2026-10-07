<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for sales reservation operations (PardRezDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->salesReservation()
 *     ->client('CLI001')
 *     ->date('2024-01-15')
 *     ->documentNumber('REZ-0001')
 *     ->currency('EUR')
 *     ->warehouse('MAIN')
 *     ->dueDate('2024-02-15')
 *     ->addProduct('PRD001', quantity: 10, amount: 199.90)
 *     ->save('RESERVATION');
 * ```
 */
final class SalesReservationBuilder extends SalesOperationBuilder
{
    protected function fullClass(): OperationClass
    {
        return OperationClass::SalesReservation;
    }

    protected function shortClass(): OperationClass
    {
        return OperationClass::SalesReservationShort;
    }
}
