<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use DateTimeInterface;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for sales reservation operations (PardRezDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->salesReservation()
 *     ->client('CLI001')
 *     ->date('2024-01-15')
 *     ->warehouse('MAIN')
 *     ->dueDate('2024-02-15')
 *     ->addProduct('PRD001', quantity: 10, price: 19.99)
 *     ->addService('SVC001', quantity: 1, price: 100.00)
 *     ->save('RESERVATION');
 * ```
 */
final class SalesReservationBuilder extends OperationBuilder
{
    protected bool $short = false;

    public function getOperationClass(): OperationClass
    {
        return $this->short ? OperationClass::SalesReservationShort : OperationClass::SalesReservation;
    }

    protected function getHeaderKey(): string
    {
        return $this->short ? 'TrumpasPardRezDok' : 'PardRezDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'PardDokPrekeDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        return 'PardDokPaslaugaDetEil';
    }

    /**
     * Use the short/simplified operation variant (TrumpasPardRezDok).
     */
    public function short(bool $short = true): self
    {
        $this->short = $short;

        return $this;
    }

    // --- Sales reservation-specific methods ---

    /**
     * Set the document series.
     */
    public function series(string $series): self
    {
        $this->header['sSerija'] = $series;

        return $this;
    }

    /**
     * Set the document type/kind.
     */
    public function documentType(string $type): self
    {
        $this->header['sDokRusis'] = $type;

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
     * Set the payment days.
     */
    public function paymentDays(int $days): self
    {
        $this->header['nAtsiskDien'] = $days;

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
     * Set if the operation is a prepayment/advance.
     */
    public function isAdvance(bool $isAdvance = true): self
    {
        $this->header['bAvansas'] = $isAdvance;

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

    /**
     * Set the price type (1-6).
     */
    public function priceType(int $type): self
    {
        $this->header['nKainosTipas'] = $type;

        return $this;
    }

    /**
     * Set total discount percentage.
     */
    public function discount(float $percent): self
    {
        $this->header['dNuolaida'] = $percent;

        return $this;
    }

    /**
     * Set VAT included flag.
     */
    public function vatIncluded(bool $included = true): self
    {
        $this->header['bPVMSkaiciuotiIKaina'] = $included;

        return $this;
    }
}
