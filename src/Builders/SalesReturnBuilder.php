<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use DateTimeInterface;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for sales return operations (PardGrazDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->salesReturn()
 *     ->client('CLI001')
 *     ->date('2024-01-20')
 *     ->warehouse('MAIN')
 *     ->originalDocument('SF-001', 'PARD', 123)
 *     ->addProduct('PRD001', quantity: 2, price: 19.99)
 *     ->save('RETURN');
 * ```
 */
final class SalesReturnBuilder extends OperationBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::SalesReturn;
    }

    protected function getHeaderKey(): string
    {
        return 'PardGrazDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'PardGrazDokPrekeDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        return 'PardGrazDokPaslaugaDetEil';
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
