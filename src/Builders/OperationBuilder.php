<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use DateTimeInterface;
use Finvalda\Concerns\FormatsDate;
use Finvalda\Enums\OperationClass;
use Finvalda\Finvalda;
use Finvalda\Responses\OperationResult;

/**
 * Abstract base class for fluent operation builders.
 */
abstract class OperationBuilder
{
    use FormatsDate;

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
    abstract public function getOperationClass(): OperationClass;

    /**
     * Get the header key for the operation data.
     */
    abstract protected function getHeaderKey(): string;

    /**
     * Get the product lines key for the operation data.
     */
    abstract protected function getProductLinesKey(): string;

    /**
     * Get the service lines key for the operation data.
     */
    abstract protected function getServiceLinesKey(): string;

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
        if (! empty($this->productLines)) {
            $payload[$productKey] = $this->productLines;
        }

        $serviceKey = $this->getServiceLinesKey();
        if (! empty($this->serviceLines)) {
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

    // --- Common Header Methods ---

    /**
     * Set the client code.
     */
    public function client(string $clientCode): static
    {
        $this->header['sKlientas'] = $clientCode;

        return $this;
    }

    /**
     * Set the operation date.
     */
    public function date(DateTimeInterface|string $date): static
    {
        $this->header['tData'] = $this->formatDate($date);

        return $this;
    }

    /**
     * Set the currency.
     */
    public function currency(string $currency): static
    {
        $this->header['sValiuta'] = $currency;

        return $this;
    }

    /**
     * Set the warehouse code.
     */
    public function warehouse(string $warehouseCode): static
    {
        $this->header['sSandelis'] = $warehouseCode;

        return $this;
    }

    /**
     * Set the description/comment.
     */
    public function description(string $description): static
    {
        $this->header['sAprasymas'] = $description;

        return $this;
    }

    /**
     * Set document number (external reference).
     */
    public function documentNumber(string $number): static
    {
        $this->header['sDokumentas'] = $number;

        return $this;
    }

    /**
     * Set analytical object level 1.
     */
    public function object1(string $code): static
    {
        $this->header['sObjektas1'] = $code;

        return $this;
    }

    /**
     * Set analytical object level 2.
     */
    public function object2(string $code): static
    {
        $this->header['sObjektas2'] = $code;

        return $this;
    }

    /**
     * Set analytical object level 3.
     */
    public function object3(string $code): static
    {
        $this->header['sObjektas3'] = $code;

        return $this;
    }

    /**
     * Set analytical object level 4.
     */
    public function object4(string $code): static
    {
        $this->header['sObjektas4'] = $code;

        return $this;
    }

    /**
     * Set analytical object level 5.
     */
    public function object5(string $code): static
    {
        $this->header['sObjektas5'] = $code;

        return $this;
    }

    /**
     * Set analytical object level 6.
     */
    public function object6(string $code): static
    {
        $this->header['sObjektas6'] = $code;

        return $this;
    }

    /**
     * Set multiple analytical objects at once.
     *
     * @param  array<int, string>  $objects  Array indexed by level (1-6)
     */
    public function objects(array $objects): static
    {
        foreach ($objects as $level => $code) {
            if ($level >= 1 && $level <= 6) {
                $this->header["sObjektas{$level}"] = $code;
            }
        }

        return $this;
    }

    /**
     * Set a custom header field.
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
        $this->productLines[] = $line->toArray();

        return $this;
    }

    /**
     * Add a product line.
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
        ], $additionalData);

        if ($amount !== null) {
            $line['dSumaV'] = $amount;
        }

        if ($price !== null) {
            $line['dKaina'] = $price;
        }

        if ($warehouse !== null) {
            $line['sSandelis'] = $warehouse;
        }

        $this->productLines[] = $line;

        return $this;
    }

    /**
     * Add a product line with all fields.
     *
     * @param  array<string, mixed>  $line
     */
    public function addProductLine(array $line): static
    {
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
        $this->serviceLines[] = $line->toArray();

        return $this;
    }

    /**
     * Add a service line.
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
            $line['dKaina'] = $price;
        }

        $this->serviceLines[] = $line;

        return $this;
    }

    /**
     * Add a service line with all fields.
     *
     * @param  array<string, mixed>  $line
     */
    public function addServiceLine(array $line): static
    {
        $this->serviceLines[] = $line;

        return $this;
    }
}
