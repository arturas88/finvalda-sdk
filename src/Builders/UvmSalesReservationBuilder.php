<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use DateTimeInterface;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for UVM sales reservation operations (UVMPardRezDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->uvmSalesReservation()
 *     ->client('HTNT')
 *     ->date('2026-04-03')
 *     ->operationType('PARDSERV')
 *     ->fulfillmentDate('2026-04-03')
 *     ->currency('EUR')
 *     ->object1('SERVISAS')
 *     ->object2('TS 444')
 *     ->object4('3186192')
 *     ->description('Workshop order #30608')
 *     ->addService('5054', quantity: 1, price: 0, additionalData: [
 *         'sAprasymas' => 'Koja užspausta',
 *     ])
 *     ->save('WORKSHOP');
 * ```
 */
final class UvmSalesReservationBuilder extends OperationBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::UvmSalesReservation;
    }

    protected function getHeaderKey(): string
    {
        return 'UVMPardRezDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'UVMPardRezDokPrekeDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        return 'UVMPardRezDokPaslaugaDetEil';
    }

    // --- UVM Sales Reservation-specific methods ---

    /**
     * Set the operation type code (e.g., 'PARDSERV' for service sales).
     */
    public function operationType(string $type): self
    {
        $this->header['sOpTipas'] = $type;

        return $this;
    }

    /**
     * Set the fulfillment/execution date.
     */
    public function fulfillmentDate(DateTimeInterface|string $date): self
    {
        $this->header['tIvykdymoData'] = $this->formatDate($date);

        return $this;
    }

    /**
     * Set the payment due date.
     */
    public function dueDate(DateTimeInterface|string $date): self
    {
        $this->header['tAtsiskData'] = $this->formatDate($date);

        return $this;
    }

    /**
     * Set payment days.
     */
    public function paymentDays(int $days): self
    {
        $this->header['nAtsiskDien'] = $days;

        return $this;
    }

    /**
     * Set VAT included in price flag.
     */
    public function vatIncluded(bool $included = true): self
    {
        $this->header['bPVMSkaiciuotiIKaina'] = $included;

        return $this;
    }

    /**
     * Set the responsible person code.
     */
    public function responsiblePerson(string $personCode): self
    {
        $this->header['sAtsakingasAsmuo'] = $personCode;

        return $this;
    }
}
