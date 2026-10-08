<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Builders\Concerns\SetsClient;
use Finvalda\Builders\Concerns\SetsCurrency;
use Finvalda\Builders\Concerns\SetsDocumentNumber;
use Finvalda\Builders\Concerns\SetsEmployee;
use Finvalda\Builders\Concerns\SetsLocked;
use Finvalda\Builders\Concerns\SetsMarked;
use Finvalda\Builders\Concerns\SetsName;
use Finvalda\Builders\Concerns\SetsNote;
use Finvalda\Enums\PaymentType;
use Finvalda\Exceptions\ValidationException;
use LogicException;

/**
 * Shared shape of inflows (IplDok) and disbursements (IsmDok): one header
 * table and one detail element (IplDokDetEil / IsmDokDetEil), nested inside
 * the wrapper like every other operation.
 *
 * The payment total is the sum of the detail lines' dSumaV; the header has no
 * amount field.
 */
abstract class PaymentBuilder extends OperationBuilder
{
    use SetsClient;
    use SetsCurrency;
    use SetsDocumentNumber;
    use SetsEmployee;
    use SetsLocked;
    use SetsMarked;
    use SetsName;
    use SetsNote;

    /** @var array<int, array<string, mixed>> */
    protected array $paymentLines = [];

    abstract protected function getPaymentLinesKey(): string;

    protected function lineMethodHint(): string
    {
        return 'payDocument()/addLine()';
    }

    /**
     * @return array<string, mixed>
     */
    public function build(): array
    {
        if (! isset($this->header['nTipas'])) {
            throw new ValidationException(
                'A payment needs its type (nTipas, required by the spec): call type(PaymentType::...), '
                . 'or payDocument(), which defaults it to PaymentType::Documents'
            );
        }

        $data = parent::build();

        if ($this->paymentLines !== []) {
            $data[$this->getHeaderKey()][$this->getPaymentLinesKey()] = $this->paymentLines;
        }

        return $data;
    }

    /**
     * Set how the payment settles documents (nTipas, required).
     */
    public function type(PaymentType $type): static
    {
        $this->header['nTipas'] = $type->value;

        return $this;
    }

    /**
     * Set the document series (sSerija).
     */
    public function series(string $series): static
    {
        $this->header['sSerija'] = $series;

        return $this;
    }

    /**
     * Pay a specific document. Sets the type to PaymentType::Documents unless
     * type() already chose one.
     */
    public function payDocument(string $series, string $document, float $amount): static
    {
        $this->header['nTipas'] ??= PaymentType::Documents->value;

        return $this->addPaymentLine([
            'dSumaV' => $amount,
            'sSerija' => $series,
            'sDokumentas' => $document,
        ]);
    }

    /**
     * Retired: v3's forDocument(document, journal, number, amount) wrote fields
     * the spec does not have. Reusing the name for the new arguments would let
     * an old call type-check and book the operation number as the amount.
     */
    public function forDocument(mixed ...$arguments): never
    {
        throw new LogicException(
            'forDocument() was removed in v4: its v3 arguments (document, journal, number, amount) '
            . 'wrote fields the WS spec does not have. Use payDocument(series, document, amount).'
        );
    }

    /**
     * Add a payment line that names no document (advance or FIFO payments).
     *
     * @param  array<string, mixed>  $additionalData  Further detail-line fields
     */
    public function addLine(float $amount, ?string $name = null, array $additionalData = []): static
    {
        $line = ['dSumaV' => $amount];

        if ($name !== null) {
            $line['sPavadinimas'] = $name;
        }

        return $this->addPaymentLine(array_merge($line, $additionalData));
    }

    /**
     * Add a payment line with all fields.
     *
     * @param  array<string, mixed>  $line
     */
    public function addPaymentLine(array $line): static
    {
        $this->paymentLines[] = $line;

        return $this;
    }
}
