<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for clearing/set-off operations (UzskaitaDok).
 *
 * Clearing operations match debit and credit entries between two clients.
 * Debit types: 1=Disbursement, 3=Sales, 4=Purchase returns, 6=Account.
 * Credit types: 0=Inflow, 2=Purchases, 5=Sales returns, 6=Account.
 *
 * Usage:
 * ```php
 * $result = $finvalda->clearing()
 *     ->date('2024-01-15')
 *     ->name('Monthly clearing')
 *     ->debtor('CLI001')
 *     ->creditor('CLI002')
 *     ->addDebitLine(amount: 270.00, series: 'SF', document: '001', type: 3)
 *     ->addCreditLine(amount: 270.00, series: 'PF', document: '002', type: 2)
 *     ->save('CLEARING');
 * ```
 */
final class ClearingBuilder extends OperationBuilder
{
    /** @var array<int, array<string, mixed>> */
    protected array $debitLines = [];

    /** @var array<int, array<string, mixed>> */
    protected array $creditLines = [];

    public function getOperationClass(): OperationClass
    {
        return OperationClass::Clearing;
    }

    protected function getHeaderKey(): string
    {
        return 'UzskaitaDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'UzskaitaDebitDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        return 'UzskaitaKreditDetEil';
    }

    /**
     * Build the complete operation data array.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $data = [];

        if (! empty($this->header)) {
            $data[$this->getHeaderKey()] = $this->header;
        }

        if (! empty($this->debitLines)) {
            $data['UzskaitaDebitDetEil'] = $this->debitLines;
        }

        if (! empty($this->creditLines)) {
            $data['UzskaitaKreditDetEil'] = $this->creditLines;
        }

        return $data;
    }

    // --- Clearing-specific methods ---

    /**
     * Set the debtor client code.
     */
    public function debtor(string $clientCode): self
    {
        $this->header['sDebitorius'] = $clientCode;

        return $this;
    }

    /**
     * Set the creditor client code.
     */
    public function creditor(string $clientCode): self
    {
        $this->header['sKreditorius'] = $clientCode;

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

    /**
     * Set the employee name.
     */
    public function employee(string $name): self
    {
        $this->header['sDarbuotojas'] = $name;

        return $this;
    }

    /**
     * Add a debit clearing line.
     *
     * Types: 1=Disbursement, 3=Sales, 4=Purchase returns, 6=Account.
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addDebitLine(
        float $amount,
        string $series,
        string $document,
        int $type,
        array $additionalData = [],
    ): self {
        $this->debitLines[] = array_merge([
            'dSumaV' => $amount,
            'sSerija' => $series,
            'sDokumentas' => $document,
            'nTipas' => $type,
        ], $additionalData);

        return $this;
    }

    /**
     * Add a credit clearing line.
     *
     * Types: 0=Inflow, 2=Purchases, 5=Sales returns, 6=Account.
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addCreditLine(
        float $amount,
        string $series,
        string $document,
        int $type,
        array $additionalData = [],
    ): self {
        $this->creditLines[] = array_merge([
            'dSumaV' => $amount,
            'sSerija' => $series,
            'sDokumentas' => $document,
            'nTipas' => $type,
        ], $additionalData);

        return $this;
    }

    /**
     * Add a debit account line (type 6).
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addDebitAccount(
        float $amount,
        string $account,
        array $additionalData = [],
    ): self {
        $this->debitLines[] = array_merge([
            'dSumaV' => $amount,
            'nTipas' => 6,
            'sSaskaita' => $account,
        ], $additionalData);

        return $this;
    }

    /**
     * Add a credit account line (type 6).
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addCreditAccount(
        float $amount,
        string $account,
        array $additionalData = [],
    ): self {
        $this->creditLines[] = array_merge([
            'dSumaV' => $amount,
            'nTipas' => 6,
            'sSaskaita' => $account,
        ], $additionalData);

        return $this;
    }
}
