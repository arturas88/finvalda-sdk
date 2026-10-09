<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use BadMethodCallException;
use DateTimeInterface;
use Finvalda\Concerns\FormatsDate;
use Finvalda\Enums\OperationClass;
use Finvalda\Exceptions\ValidationException;
use Finvalda\Finvalda;
use Finvalda\Responses\OperationResult;
use LogicException;

/**
 * Abstract base class for fluent operation builders.
 *
 * Only what every operation shares lives here: the operation date and the raw
 * escape hatches. Header setters are composed per builder from
 * Builders\Concerns\Sets* traits, so a builder offers a setter only when its
 * envelope has the field in the spec — the server silently drops unknown tags,
 * so an unsupported setter would be a silent no-op.
 */
abstract class OperationBuilder
{
    use FormatsDate;

    /**
     * Setters removed in v4: the field each wrote, what to use instead (if
     * anything), and the v3 builders that had it (null: every builder, via
     * this base class). Kept for one major release so an old call explains
     * itself instead of failing with a bare "undefined method".
     */
    private const RETIRED_SETTERS = [
        'paymentDays' => ['nAtsiskDien', 'set the due date with dueDate()', ['PurchaseBuilder', 'PurchaseOrderBuilder', 'PurchaseReturnBuilder', 'SaleBuilder', 'SalesReservationBuilder', 'SalesReturnBuilder', 'UvmPurchaseOrderBuilder', 'UvmSalesReservationBuilder']],
        'isAdvance' => ['bAvansas', null, ['DisbursementBuilder', 'InflowBuilder', 'PurchaseBuilder', 'SaleBuilder', 'SalesReservationBuilder']],
        'vatIncluded' => ['bPVMSkaiciuotiIKaina', 'send net line amounts and the VAT with vat(percent:, amount:)', ['PurchaseBuilder', 'PurchaseOrderBuilder', 'SaleBuilder', 'SalesReservationBuilder', 'UvmPurchaseOrderBuilder', 'UvmSalesReservationBuilder']],
        'priceType' => ['nKainosTipas', null, ['SaleBuilder', 'SalesReservationBuilder']],
        'responsiblePerson' => ['sAtsakingasAsmuo', null, ['DisbursementBuilder', 'InflowBuilder', 'InternalTransferBuilder', 'PurchaseBuilder', 'PurchaseOrderBuilder', 'PurchaseReturnBuilder', 'SaleBuilder', 'SalesReservationBuilder', 'SalesReturnBuilder', 'UvmPurchaseOrderBuilder', 'UvmSalesReservationBuilder']],
        'supplierInvoice' => ['sTiekejoSF', 'put the supplier invoice number in documentNumber()', ['PurchaseBuilder']],
        'supplierInvoiceDate' => ['tTiekejoSFData', null, ['PurchaseBuilder']],
        'originalDocument' => ['sGrazDokumentas', null, ['PurchaseReturnBuilder', 'SalesReturnBuilder']],
        'originalDocumentNumber' => ['sGrazZurnalas/nGrazNumeris', null, ['PurchaseReturnBuilder', 'SalesReturnBuilder']],
        'reason' => ['sGrazPriezastis', null, ['PurchaseReturnBuilder', 'SalesReturnBuilder']],
        'operationType' => ['sOpTipas', 'the operation type comes from the sParametras profile', ['UvmPurchaseOrderBuilder', 'UvmSalesReservationBuilder']],
        'bankAccount' => ['sBankoSask', 'the account comes from the sParametras profile', ['DisbursementBuilder', 'InflowBuilder']],
        'cashRegister' => ['sKasa', 'the cash register comes from the sParametras profile', ['DisbursementBuilder', 'InflowBuilder']],
        'amount' => ['dSuma', 'put amounts on the lines with addLine()/payDocument()', ['DisbursementBuilder', 'InflowBuilder']],
        'description' => ['sAprasymas', null, null],
        'client' => ['sKlientas', null, null],
        'currency' => ['sValiuta', null, null],
        'documentNumber' => ['sDokumentas', null, null],
        'warehouse' => ['sSandelis', 'internal transfers use fromWarehouse()/toWarehouse(); otherwise set the warehouse on each line', null],
        'object1' => ['sObjektas1', 'set objects on the lines', null],
        'object2' => ['sObjektas2', 'set objects on the lines', null],
        'object3' => ['sObjektas3', 'set objects on the lines', null],
        'object4' => ['sObjektas4', 'set objects on the lines', null],
        'object5' => ['sObjektas5', 'set objects on the lines', null],
        'object6' => ['sObjektas6', 'set objects on the lines', null],
        'objects' => ['sObjektas1..6', 'set objects on the lines', null],
    ];

    /** @var array<string, mixed> */
    protected array $header = [];

    /** @var array<int, array<string, mixed>> */
    protected array $productLines = [];

    /** @var array<int, array<string, mixed>> */
    protected array $serviceLines = [];

    protected ?Finvalda $finvalda = null;

    protected ?string $parameter = null;

    /**
     * Get the operation class for this builder.
     */
    /**
     * Explain a setter removed in v4 (RETIRED_SETTERS); anything else is the
     * ordinary undefined-method error. method_exists() stays false for both.
     *
     * @param  array<int, mixed>  $arguments
     */
    public function __call(string $method, array $arguments): never
    {
        $shortName = (new \ReflectionClass($this))->getShortName();
        [$field, $instead, $hadIt] = self::RETIRED_SETTERS[$method] ?? [null, null, []];

        if ($field === null || ($hadIt !== null && ! in_array($shortName, $hadIt, true))) {
            throw new BadMethodCallException(sprintf('Call to undefined method %s::%s()', static::class, $method));
        }

        throw new LogicException(sprintf(
            '%s() was removed in v4 from %s: it wrote %s, which the WS spec does not define for %s, and the '
            . 'server ignored it. Delete the call%s.',
            $method,
            $shortName,
            $field,
            $this->getHeaderKey(),
            $instead !== null ? "; {$instead}" : '',
        ));
    }

    abstract public function getOperationClass(): OperationClass;

    /**
     * Get the header key for the operation data.
     */
    protected function getHeaderKey(): string
    {
        return $this->getOperationClass()->value;
    }

    /**
     * Detail element for generic product lines, or null when the operation takes
     * none (product() / addProduct() then throw).
     */
    protected function getProductLinesKey(): ?string
    {
        return null;
    }

    /**
     * Detail element for generic service lines, or null when the operation takes
     * none (service() / addService() then throw).
     */
    protected function getServiceLinesKey(): ?string
    {
        return null;
    }

    /**
     * The builder's own line method, named in the error when a generic
     * product/service line is added to an operation that has none.
     */
    protected function lineMethodHint(): string
    {
        return 'the builder\'s own line methods';
    }

    /**
     * Set the Finvalda instance for saving.
     */
    public function using(Finvalda $finvalda): static
    {
        $this->finvalda = $finvalda;

        return $this;
    }

    /**
     * Set the server-configured import parameter.
     */
    public function parameter(string $parameter): static
    {
        $this->parameter = $parameter;

        return $this;
    }

    /**
     * Build the complete operation data array.
     *
     * Finvalda expects the operation wrapped under its class key, with
     * detail-row arrays nested INSIDE the wrapper (siblings of header fields):
     *   { "<HeaderKey>": { ...header..., "<DetailKey>": [...] } }
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $payload = $this->header;

        $productKey = $this->getProductLinesKey();
        if ($productKey !== null && $this->productLines !== []) {
            $payload[$productKey] = $this->productLines;
        }

        $serviceKey = $this->getServiceLinesKey();
        if ($serviceKey !== null && $this->serviceLines !== []) {
            $payload[$serviceKey] = $this->serviceLines;
        }

        return [$this->getHeaderKey() => $payload];
    }

    /**
     * Save the operation using the configured Finvalda instance.
     *
     * @throws \RuntimeException If Finvalda instance or parameter is not set
     */
    public function save(?string $parameter = null): OperationResult
    {
        if ($this->finvalda === null) {
            throw new \RuntimeException('Finvalda instance not set. Use using() method first.');
        }

        $param = $parameter ?? $this->parameter;
        if ($param === null) {
            throw new \RuntimeException('Parameter not set. Use parameter() method or pass to save().');
        }

        return $this->finvalda->operations()->create(
            $this->getOperationClass(),
            $this->build(),
            $param
        );
    }

    /**
     * Set the operation date (tData). Every operation envelope has it.
     */
    public function date(DateTimeInterface|string $date): static
    {
        $this->header['tData'] = $this->formatDate($date);

        return $this;
    }

    /**
     * Set a raw header field. Escape hatch for spec fields without a named
     * setter; the key is sent as given and not checked.
     */
    public function setHeader(string $key, mixed $value): static
    {
        $this->header[$key] = $value;

        return $this;
    }

    // --- Product Line Methods ---

    /**
     * Add a product line using a fluent ProductLine DTO.
     *
     * ```php
     * ->product(ProductLine::make('MILTAI', 12.25)
     *     ->warehouse('CENTR.')
     *     ->amount(161.16, local: 161.16)
     *     ->vat(percent: 21, amount: 33.84, amountLocal: 33.84))
     * ```
     */
    public function product(ProductLine $line): static
    {
        return $this->addProductLine($line->toArray());
    }

    /**
     * Add a product line.
     *
     * Note: $quantity is sent as the raw nKiekis value (no scaling). nPirmasMat defaults
     * to 1 so Finvalda reads nKiekis in the FIRST (primary) unit verbatim — matching
     * ProductLine::make(). Without the flag, Finvalda reads nKiekis in the SECOND unit and
     * rescales it by the product's first/second ratio (e.g. 250 on an "M" product becomes
     * 2.5 m). To opt out, pass additionalData: ['nPirmasMat' => 0], or use the fully-raw
     * addProductLine() to control the line array (including omitting nPirmasMat).
     *
     * $price is the unit price without VAT and discount (dSumaVntV); sales lines
     * only — purchase lines have no unit-price field.
     *
     * @param  array<string, mixed>  $additionalData  Additional fields for the line
     */
    public function addProduct(
        string $code,
        float $quantity,
        ?float $amount = null,
        ?float $price = null,
        ?string $warehouse = null,
        array $additionalData = [],
    ): static {
        $line = array_merge([
            'sKodas' => $code,
            'nKiekis' => $quantity,
            'nPirmasMat' => 1,
        ], $additionalData);

        if ($amount !== null) {
            $line['dSumaV'] = $amount;
        }

        if ($price !== null) {
            $line['dSumaVntV'] = $price;
        }

        if ($warehouse !== null) {
            $line['sSandelis'] = $warehouse;
        }

        return $this->addProductLine($line);
    }

    /**
     * Add a product line with all fields.
     *
     * @param  array<string, mixed>  $line
     *
     * @throws BadMethodCallException  When the operation has no generic product lines.
     */
    public function addProductLine(array $line): static
    {
        $this->assertAcceptsLines($this->getProductLinesKey(), 'product');

        $this->productLines[] = $line;

        return $this;
    }

    // --- Service Line Methods ---

    /**
     * Add a service line using a fluent ServiceLine DTO.
     *
     * ```php
     * ->service(ServiceLine::make('TRANSPORT', 1)
     *     ->amount(50.00, local: 50.00)
     *     ->vat(percent: 21, amount: 10.50, amountLocal: 10.50))
     * ```
     */
    public function service(ServiceLine $line): static
    {
        return $this->addServiceLine($line->toArray());
    }

    /**
     * Add a service line.
     *
     * Note: $quantity is sent as the raw nKiekis value. Unlike ServiceLine,
     * this helper does NOT apply the second-measurement ×100 scaling — pass
     * the already-scaled value (e.g. 100 for one unit) or use ServiceLine::make()
     * which handles the convention for you.
     *
     * $price is the unit price without VAT and discount (dSumaVntV); sales lines
     * only — purchase lines have no unit-price field.
     *
     * @param  array<string, mixed>  $additionalData  Additional fields for the line
     */
    public function addService(
        string $code,
        float $quantity,
        ?float $amount = null,
        ?float $price = null,
        array $additionalData = [],
    ): static {
        $line = array_merge([
            'sKodas' => $code,
            'nKiekis' => $quantity,
        ], $additionalData);

        if ($amount !== null) {
            $line['dSumaV'] = $amount;
        }

        if ($price !== null) {
            $line['dSumaVntV'] = $price;
        }

        return $this->addServiceLine($line);
    }

    /**
     * Add a service line with all fields.
     *
     * @param  array<string, mixed>  $line
     *
     * @throws BadMethodCallException  When the operation has no generic service lines.
     */
    public function addServiceLine(array $line): static
    {
        $this->assertAcceptsLines($this->getServiceLinesKey(), 'service');

        $this->serviceLines[] = $line;

        return $this;
    }

    /**
     * @throws BadMethodCallException
     */
    private function assertAcceptsLines(?string $key, string $kind): void
    {
        if ($key === null) {
            throw new BadMethodCallException(
                static::class . " does not support generic {$kind} lines; use {$this->lineMethodHint()} instead."
            );
        }
    }

    /**
     * Refuse a due date (tMokejimoData) before the document date (tData):
     * dates often come from OCR/LLM reads, and a swapped pair books an invoice
     * that is overdue the day it is issued.
     *
     * @throws ValidationException
     */
    protected function assertDueDateNotBeforeDocumentDate(): void
    {
        $date = $this->header['tData'] ?? null;
        $due = $this->header['tMokejimoData'] ?? null;

        if (is_string($date) && is_string($due) && substr($due, 0, 10) < substr($date, 0, 10)) {
            throw new ValidationException(
                "{$this->getHeaderKey()}: the due date (tMokejimoData {$due}) is before the document date (tData {$date})"
            );
        }
    }

    /**
     * Refuse line fields the operation's detail element does not define — a
     * field the server does not know is silently dropped.
     *
     * @param  array<int, array<string, mixed>>  $lines
     * @param  list<string>  $fields
     *
     * @throws ValidationException
     */
    protected function rejectLineFields(array $lines, string $element, array $fields, string $why): void
    {
        foreach ($lines as $line) {
            $found = array_values(array_intersect(array_keys($line), $fields));

            if ($found !== []) {
                throw new ValidationException(sprintf(
                    '%s does not accept %s (%s)',
                    $element,
                    implode(', ', $found),
                    $why,
                ));
            }
        }
    }

    /**
     * Refuse header fields outside an allow-list — used by short (Trumpas*)
     * variants, whose envelope accepts only a handful of fields.
     *
     * @param  list<string>  $allowed
     *
     * @throws ValidationException
     */
    protected function assertHeaderOnly(array $allowed): void
    {
        $extra = array_values(array_diff(array_keys($this->header), $allowed));

        if ($extra !== []) {
            throw new ValidationException(sprintf(
                '%s does not accept %s; it takes only %s',
                $this->getHeaderKey(),
                implode(', ', $extra),
                implode(', ', $allowed),
            ));
        }
    }
}
