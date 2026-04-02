<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use DateTimeInterface;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for purchase return operations (PirkGrazDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->purchaseReturn()
 *     ->client('SUP001')
 *     ->date('2024-01-20')
 *     ->warehouse('MAIN')
 *     ->originalDocument('SF-001', 'PIRK', 456)
 *     ->addProduct('PRD001', quantity: 10, price: 9.99)
 *     ->save('RETURN');
 * ```
 */
final class PurchaseReturnBuilder extends OperationBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::PurchaseReturn;
    }

    protected function getHeaderKey(): string
    {
        return 'PirkGrazDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'PirkGrazDokPrekeDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        return 'PirkGrazDokPaslaugaDetEil';
    }

    // --- Return-specific methods ---

    /**
     * Set the original document reference.
     */
    public function originalDocument(string $document, string $journal, int $number): self
    {
        $this->header['sGrazDokumentas'] = $document;
        $this->header['sGrazZurnalas'] = $journal;
        $this->header['nGrazNumeris'] = $number;

        return $this;
    }

    /**
     * Set the original document number.
     */
    public function originalDocumentNumber(string $document): self
    {
        $this->header['sGrazDokumentas'] = $document;

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
     * Set the return reason.
     */
    public function reason(string $reason): self
    {
        $this->header['sGrazPriezastis'] = $reason;

        return $this;
    }
}
