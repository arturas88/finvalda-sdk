<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for disbursement/payment out operations (IsmokasDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->disbursement()
 *     ->client('SUP001')
 *     ->date('2024-01-15')
 *     ->amount(1000.00)
 *     ->forDocument('SF-001', 'PIRK', 456)
 *     ->save('DISBURSEMENT');
 * ```
 */
final class DisbursementBuilder extends OperationBuilder
{
    /** @var array<int, array<string, mixed>> */
    protected array $paymentLines = [];

    public function getOperationClass(): OperationClass
    {
        return OperationClass::Disbursement;
    }

    protected function getHeaderKey(): string
    {
        return 'IsmokasDok';
    }

    protected function getProductLinesKey(): string
    {
        // Disbursements don't have product lines
        return 'IsmokasDokDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        // Disbursements don't have service lines
        return 'IsmokasDokPaslaugaDetEil';
    }

    /**
     * Build the complete operation data array.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $data = parent::build();

        // Add payment lines
        if (! empty($this->paymentLines)) {
            $data['IsmokasDokDetEil'] = $this->paymentLines;
        }

        return $data;
    }

    // --- Disbursement-specific methods ---

    /**
     * Set the payment amount.
     */
    public function amount(float $amount): self
    {
        $this->header['dSuma'] = $amount;

        return $this;
    }

    /**
     * Set the bank account code.
     */
    public function bankAccount(string $accountCode): self
    {
        $this->header['sBankoSask'] = $accountCode;

        return $this;
    }

    /**
     * Set the cash register code.
     */
    public function cashRegister(string $code): self
    {
        $this->header['sKasa'] = $code;

        return $this;
    }

    /**
     * Add a payment allocation to a specific document.
     */
    public function forDocument(
        string $document,
        string $journal,
        int $number,
        ?float $amount = null,
    ): self {
        $line = [
            'sDokumentas' => $document,
            'sZurnalas' => $journal,
            'nNumeris' => $number,
        ];

        if ($amount !== null) {
            $line['dSuma'] = $amount;
        }

        $this->paymentLines[] = $line;

        return $this;
    }

    /**
     * Add a payment line with all fields.
     *
     * @param  array<string, mixed>  $line
     */
    public function addPaymentLine(array $line): self
    {
        $this->paymentLines[] = $line;

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
     * Set as advance payment.
     */
    public function isAdvance(bool $isAdvance = true): self
    {
        $this->header['bAvansas'] = $isAdvance;

        return $this;
    }
}
