<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for inflow/payment received operations (IplDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->inflow()
 *     ->client('CLI001')
 *     ->date('2024-01-15')
 *     ->currency('EUR')
 *     ->documentNumber('KPO-0001')
 *     ->type(PaymentType::Documents)
 *     ->payDocument('SF', '000123', 500.00)
 *     ->save('INFLOW');
 * ```
 */
final class InflowBuilder extends PaymentBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::Inflow;
    }

    protected function getPaymentLinesKey(): string
    {
        return 'IplDokDetEil';
    }
}
