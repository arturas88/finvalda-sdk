<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Builders\Concerns\BuildsPaymentOperation;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for an inflow (payment received): IplDok with IplDokDetEil rows (FVS web service reference).
 *
 * Usage:
 * ```php
 * $result = $finvalda->inflow()
 *     ->client('CLI001')
 *     ->date('2024-01-15')
 *     ->name('Payment for SF-001')
 *     ->settle('SF', '001', 500.00)
 *     ->save('INFLOW');
 * ```
 */
final class InflowBuilder extends OperationBuilder
{
    use BuildsPaymentOperation;

    public function getOperationClass(): OperationClass
    {
        return OperationClass::Inflow;
    }

    protected function getHeaderKey(): string
    {
        return 'IplDok';
    }

    protected function getProductLinesKey(): string
    {
        // the payment rows
        return 'IplDokDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        // payments have no service rows; addService() is refused in build()
        return 'IplDokDetEil';
    }
}
