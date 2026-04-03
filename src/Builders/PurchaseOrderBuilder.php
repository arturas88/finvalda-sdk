<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use DateTimeInterface;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for purchase order operations (PirkUzsDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->purchaseOrder()
 *     ->client('SUP001')
 *     ->date('2024-01-15')
 *     ->currency('EUR')
 *     ->addProduct('PRD001', quantity: 24, price: 3.50, warehouse: 'CENTR.')
 *     ->save('ORDER');
 * ```
 */
final class PurchaseOrderBuilder extends OperationBuilder
{
    protected bool $short = false;

    public function getOperationClass(): OperationClass
    {
        return $this->short ? OperationClass::PurchaseOrderShort : OperationClass::PurchaseOrder;
    }

    protected function getHeaderKey(): string
    {
        return $this->short ? 'TrumpasPirkUzsDok' : 'PirkUzsDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'PirkDokPrekeDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        return 'PirkDokPaslaugaDetEil';
    }

    /**
     * Use the short/simplified operation variant (TrumpasPirkUzsDok).
     */
    public function short(bool $short = true): self
    {
        $this->short = $short;

        return $this;
    }

    // --- Purchase order-specific methods ---

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
     * Set the responsible person code.
     */
    public function responsiblePerson(string $personCode): self
    {
        $this->header['sAtsakingasAsmuo'] = $personCode;

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

    /**
     * Set the operation name/title.
     */
    public function name(string $name): self
    {
        $this->header['sPavadinimas'] = $name;

        return $this;
    }
}
