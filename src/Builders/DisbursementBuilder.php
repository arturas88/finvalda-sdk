<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for disbursement/payment out operations (IsmDok).
 *
 * IsmDok is documented (shared table "IplDok, IsmDok") but missing from the
 * spec's InsertNewOperation ItemClassName list; it is unverified against a
 * live server. The Mokejimas (payment order) node is not supported.
 *
 * Usage:
 * ```php
 * $result = $finvalda->disbursement()
 *     ->client('SUP001')
 *     ->date('2024-01-15')
 *     ->currency('EUR')
 *     ->documentNumber('KIO-0001')
 *     ->type(PaymentType::Documents)
 *     ->forDocument('PF', '000456', 250.00)
 *     ->save('DISBURSEMENT');
 * ```
 */
final class DisbursementBuilder extends PaymentBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::Disbursement;
    }

    protected function getPaymentLinesKey(): string
    {
        return 'IsmDokDetEil';
    }
}
