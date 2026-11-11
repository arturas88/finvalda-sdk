<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Builders\Concerns\BuildsPaymentOperation;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for an disbursement (payment out): IsmDok with IsmDokDetEil rows (FVS web service reference).
 *
 * Usage:
 * ```php
 * $result = $finvalda->disbursement()
 *     ->client('SUP001')
 *     ->date('2024-01-15')
 *     ->settle('', 'PO-001', 1000.00)
 *     ->save('DISBURSEMENT');
 * ```
 */
final class DisbursementBuilder extends OperationBuilder
{
    use BuildsPaymentOperation;

    public function getOperationClass(): OperationClass
    {
        return OperationClass::Disbursement;
    }

    protected function getHeaderKey(): string
    {
        return 'IsmDok';
    }

    protected function getProductLinesKey(): string
    {
        // the payment rows
        return 'IsmDokDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        // payments have no service rows; addService() is refused in build()
        return 'IsmDokDetEil';
    }
}
