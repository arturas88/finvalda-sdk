<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for sales operations (PardDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->sale()
 *     ->client('CLI001')
 *     ->date('2024-01-15')
 *     ->documentNumber('SF-0001')
 *     ->currency('EUR')
 *     ->warehouse('MAIN')
 *     ->addProduct('PRD001', quantity: 10, amount: 199.90, price: 19.99)
 *     ->addService('SVC001', quantity: 100, amount: 100.00)
 *     ->save('STANDARD');
 * ```
 */
final class SaleBuilder extends SalesOperationBuilder
{
    protected function fullClass(): OperationClass
    {
        return OperationClass::Sale;
    }

    protected function shortClass(): OperationClass
    {
        return OperationClass::SaleShort;
    }
}
