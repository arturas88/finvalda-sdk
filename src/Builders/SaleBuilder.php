<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use DateTimeInterface;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for sales operations (PardDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->sale()
 *     ->client('CLI001')
 *     ->date('2024-01-15')
 *     ->warehouse('MAIN')
 *     ->addProduct('PRD001', quantity: 10, price: 19.99)
 *     ->addProduct('PRD002', quantity: 5, amount: 49.95)
 *     ->addService('SVC001', quantity: 1, price: 100.00)
 *     ->save('STANDARD');
 * ```
 */
final class SaleBuilder extends OperationBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::Sale;
    }

    protected function getHeaderKey(): string
    {
        return 'PardDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'PardDokPrekeDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        return 'PardDokPaslaugaDetEil';
    }

    // --- Sales-specific methods ---

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
