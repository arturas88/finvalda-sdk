<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

use DateTimeInterface;

/**
 * Header and detail rows of the two payment operations, inflow (IplDok / IplDokDetEil) and disbursement
 * (IsmDok / IsmDokDetEil), as the FVS web service reference defines them (docs/FVS_Webservice.md, "IplDok, IsmDok").
 *
 * - nTipas is required: 0 = advance, 1 = settle FIFO, 3 = settle the named documents (rows carry sSerija + sDokumentas).
 * - A row's amount is dSumaV. There is no header amount, bank account or cash desk: the server-side parameter
 *   (sParametras) decides the journal and the operation type, and with it the account.
 * - Detail rows sit inside the operation wrapper, next to the header fields.
 *
 * Verified against a live server: IplDok with nTipas 3 and rows {sPavadinimas, dSumaV, sSerija, sDokumentas} books and
 * settles the named sale; IsmokasDok is refused as "Wrong ItemClassName".
 */
trait BuildsPaymentOperation
{
    /** @var array<int, array<string, mixed>> */
    protected array $paymentLines = [];

    /** nTipas 0: an advance payment, not settled against documents. */
    public function advance(): static
    {
        $this->header['nTipas'] = 0;

        return $this;
    }

    /** nTipas 1: Finvalda settles the client's open documents first in, first out. */
    public function settleFifo(): static
    {
        $this->header['nTipas'] = 1;

        return $this;
    }

    /** Set nTipas directly (0 advance, 1 FIFO, 3 named documents). */
    public function type(int $type): static
    {
        $this->header['nTipas'] = $type;

        return $this;
    }

    /**
     * Settle one named document (nTipas 3): its series and number, and the amount paid on it.
     * Sets nTipas 3 unless a type was chosen already.
     */
    public function settle(string $series, string $document, float $amount, ?string $name = null): static
    {
        $this->header['nTipas'] ??= 3;
        $line = ['dSumaV' => $amount, 'sSerija' => $series, 'sDokumentas' => $document];
        if ($name !== null) {
            $line = ['sPavadinimas' => $name] + $line;
        }
        $this->paymentLines[] = $line;

        return $this;
    }

    /**
     * Add a row with no document (advance or FIFO). $extra takes the other row fields of the reference:
     * sDokNrBendrMokejime, sSutartis, sObjektas1..4.
     *
     * @param  array<string, mixed>  $extra
     */
    public function line(float $amount, ?string $name = null, array $extra = []): static
    {
        $line = ['dSumaV' => $amount] + $extra;
        if ($name !== null) {
            $line = ['sPavadinimas' => $name] + $line;
        }
        $this->paymentLines[] = $line;

        return $this;
    }

    /** sPavadinimas: the operation's first name (50 chars). */
    public function name(string $name): static
    {
        $this->header['sPavadinimas'] = $name;

        return $this;
    }

    /** sPastaba: a note on the operation (255 chars). */
    public function note(string $note): static
    {
        $this->header['sPastaba'] = $note;

        return $this;
    }

    /** tIsrasymoData: the document issue date. */
    public function issueDate(DateTimeInterface|string $date): static
    {
        $this->header['tIsrasymoData'] = $this->formatDate($date);

        return $this;
    }

    /** sKlientImonesKodas: the client's company code, used when no client code is given. */
    public function clientCompanyCode(string $code): static
    {
        $this->header['sKlientImonesKodas'] = $code;

        return $this;
    }

    /** sSerija + sDokumentas of the operation's own document. */
    public function document(string $series, string $number): static
    {
        $this->header['sSerija'] = $series;
        $this->header['sDokumentas'] = $number;

        return $this;
    }

    /** nPozymis: mark the operation. */
    public function marked(bool $marked = true): static
    {
        $this->header['nPozymis'] = $marked ? 1 : 0;

        return $this;
    }

    /** nVarna: lock the operation. */
    public function locked(bool $locked = true): static
    {
        $this->header['nVarna'] = $locked ? 1 : 0;

        return $this;
    }

    /** sDarbuotojas: the Finvalda employee name. */
    public function employee(string $employee): static
    {
        $this->header['sDarbuotojas'] = $employee;

        return $this;
    }

    /**
     * Add a raw row (any field of the reference).
     *
     * @param  array<string, mixed>  $line
     */
    public function addPaymentLine(array $line): static
    {
        $this->paymentLines[] = $line;

        return $this;
    }

    /**
     * @deprecated 3.9.0 Not a field of IplDok / IsmDok (the parameter decides the account). Use settle() or line() rows.
     */
    public function amount(float $amount): static
    {
        $this->header['dSuma'] = $amount;

        return $this;
    }

    /** @deprecated 3.9.0 Not a field of IplDok / IsmDok: the parameter (sParametras) decides the bank account. */
    public function bankAccount(string $accountCode): static
    {
        $this->header['sBankoSask'] = $accountCode;

        return $this;
    }

    /** @deprecated 3.9.0 Not a field of IplDok / IsmDok: the parameter (sParametras) decides the cash desk. */
    public function cashRegister(string $code): static
    {
        $this->header['sKasa'] = $code;

        return $this;
    }

    /** @deprecated 3.9.0 Not a field of IplDok / IsmDok. Use advance() (nTipas 0). */
    public function isAdvance(bool $isAdvance = true): static
    {
        $this->header['bAvansas'] = $isAdvance;

        return $this;
    }

    /** @deprecated 3.9.0 Not a field of IplDok / IsmDok. */
    public function responsiblePerson(string $personCode): static
    {
        $this->header['sAtsakingasAsmuo'] = $personCode;

        return $this;
    }

    /**
     * @deprecated 3.9.0 Its row (sZurnalas, nNumeris, dSuma) is not the reference's row. Use settle($series, $document, $amount).
     */
    public function forDocument(string $document, string $journal, int $number, ?float $amount = null): static
    {
        $line = ['sDokumentas' => $document, 'sZurnalas' => $journal, 'nNumeris' => $number];
        if ($amount !== null) {
            $line['dSuma'] = $amount;
        }
        $this->paymentLines[] = $line;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $this->assertNoGenericLines('settle() or line()');
        $data = parent::build();
        if (! empty($this->paymentLines)) {
            // Inside the wrapper, next to the header fields (before 3.9.0 the rows sat outside it).
            $data[$this->getHeaderKey()][$this->getProductLinesKey()] = $this->paymentLines;
        }

        return $data;
    }
}
