<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Builders\Concerns\SetsEmployeeByName;
use Finvalda\Builders\Concerns\SetsName;
use Finvalda\Enums\ClearingDocumentType;
use Finvalda\Enums\OperationClass;
use Finvalda\Exceptions\ValidationException;

/**
 * Fluent builder for clearing/set-off operations (UzskaitaDok).
 *
 * Clearing operations match debit and credit entries between two clients.
 * Debit types: 1=Disbursement, 3=Sales, 4=Purchase returns, 6=Account.
 * Credit types: 0=Inflow, 2=Purchases, 5=Sales returns, 6=Account.
 * 0 and 1 are inferred (the spec drops their numbers) and accepted on either
 * side until a server confirms them; see ClearingDocumentType.
 *
 * Usage:
 * ```php
 * $result = $finvalda->clearing()
 *     ->date('2024-01-15')
 *     ->name('Monthly clearing')
 *     ->debtor('CLI001')
 *     ->creditor('CLI002')
 *     ->addDebitLine(amount: 270.00, series: 'SF', document: '001', type: ClearingDocumentType::Sale)
 *     ->addCreditLine(amount: 270.00, series: 'PF', document: '002', type: ClearingDocumentType::Purchase)
 *     ->save('CLEARING');
 * ```
 */
final class ClearingBuilder extends OperationBuilder
{
    use SetsEmployeeByName;
    use SetsName;

    /** @var array<int, array<string, mixed>> */
    protected array $debitLines = [];

    /** @var array<int, array<string, mixed>> */
    protected array $creditLines = [];

    public function getOperationClass(): OperationClass
    {
        return OperationClass::Clearing;
    }

    protected function lineMethodHint(): string
    {
        return 'addDebitLine()/addCreditLine()';
    }

    /**
     * Build the complete operation data array.
     *
     * Debit/credit detail rows are nested inside the UzskaitaDok wrapper,
     * matching the docs XML examples and the official Postman collection.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $payload = $this->header;

        if (! empty($this->debitLines)) {
            $payload['UzskaitaDebitDetEil'] = $this->debitLines;
        }

        if (! empty($this->creditLines)) {
            $payload['UzskaitaKreditDetEil'] = $this->creditLines;
        }

        return [$this->getHeaderKey() => $payload];
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
     * Add a debit clearing line.
     *
     * Types: 1=Disbursement, 3=Sales, 4=Purchase returns, 6=Account.
     *
     * @param  array<string, mixed>  $additionalData
     *
     * @throws ValidationException  On a type the debit side does not accept.
     */
    public function addDebitLine(
        float $amount,
        string $series,
        string $document,
        ClearingDocumentType|int $type,
        array $additionalData = [],
    ): self {
        $this->debitLines[] = array_merge([
            'dSumaV' => $amount,
            'sSerija' => $series,
            'sDokumentas' => $document,
            'nTipas' => self::typeFor($type, debit: true),
        ], $additionalData);

        return $this;
    }

    /**
     * Add a credit clearing line.
     *
     * Types: 0=Inflow, 2=Purchases, 5=Sales returns, 6=Account.
     *
     * @param  array<string, mixed>  $additionalData
     *
     * @throws ValidationException  On a type the credit side does not accept.
     */
    public function addCreditLine(
        float $amount,
        string $series,
        string $document,
        ClearingDocumentType|int $type,
        array $additionalData = [],
    ): self {
        $this->creditLines[] = array_merge([
            'dSumaV' => $amount,
            'sSerija' => $series,
            'sDokumentas' => $document,
            'nTipas' => self::typeFor($type, debit: false),
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
            'nTipas' => ClearingDocumentType::Account->value,
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
            'nTipas' => ClearingDocumentType::Account->value,
            'sSaskaita' => $account,
        ], $additionalData);

        return $this;
    }

    /**
     * @throws ValidationException
     */
    private static function typeFor(ClearingDocumentType|int $type, bool $debit): int
    {
        $case = $type instanceof ClearingDocumentType ? $type : ClearingDocumentType::tryFrom($type);
        $side = $debit ? 'debit' : 'credit';

        if ($case === null || ! ($debit ? $case->isDebit() : $case->isCredit())) {
            $given = $type instanceof ClearingDocumentType ? $type->name : (string) $type;

            throw new ValidationException(
                "Clearing type {$given} is not valid on the {$side} side; "
                . ($debit ? 'use 0, 1, 3, 4 or 6' : 'use 0, 1, 2, 5 or 6')
            );
        }

        return $case->value;
    }
}
