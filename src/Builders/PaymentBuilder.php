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
        return 'forDocument()/addLine()';
    }

    /**
     * @return array<string, mixed>
     */
    public function build(): array
    {
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
     * Pay a specific document (with type(PaymentType::Documents)).
     */
    public function forDocument(string $series, string $document, float $amount): static
    {
        return $this->addPaymentLine([
            'dSumaV' => $amount,
            'sSerija' => $series,
            'sDokumentas' => $document,
        ]);
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
