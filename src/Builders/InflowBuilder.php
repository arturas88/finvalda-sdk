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
 *     ->amount(500.00)
 *     ->forDocument('SF-001', 'PARD', 123)
 *     ->save('INFLOW');
 * ```
 */
final class InflowBuilder extends OperationBuilder
{
    /** @var array<int, array<string, mixed>> */
    protected array $paymentLines = [];

    public function getOperationClass(): OperationClass
    {
        return OperationClass::Inflow;
    }

    protected function getHeaderKey(): string
    {
        return 'IplDok';
    }

    protected function getProductLinesKey(): string
    {
        // Inflows don't have product lines
        return 'IplDokDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        // Inflows don't have service lines
        return 'IplDokPaslaugaDetEil';
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
            $data['IplDokDetEil'] = $this->paymentLines;
        }

        return $data;
    }

    // --- Inflow-specific methods ---

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

    /**
     * Set the operation locked flag.
     */
    public function locked(bool $locked = true): self
    {
        $this->header['nVarna'] = $locked ? 1 : 0;

        return $this;
    }

    /**
     * Set the Finvalda employee name.
     */
    public function employee(string $employee): self
    {
        $this->header['sDarbuotojas'] = $employee;

        return $this;
    }
}
