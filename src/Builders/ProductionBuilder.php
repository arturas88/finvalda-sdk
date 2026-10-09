<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Builders\Concerns\SetsClient;
use Finvalda\Builders\Concerns\SetsDocumentNumber;
use Finvalda\Builders\Concerns\SetsEmployeeByName;
use Finvalda\Builders\Concerns\SetsMarked;
use Finvalda\Builders\Concerns\SetsNote;
use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for production operations (GamybaDok).
 *
 * Production operations have three line types: finished goods, raw materials, and services.
 *
 * Usage:
 * ```php
 * $result = $finvalda->production()
 *     ->date('2024-01-15')
 *     ->finishedProduct('FINISHED001')
 *     ->documentNumber('PROD-001')
 *     ->description('Daily production run')
 *     ->addFinishedGood('FINISHED001', warehouse: 'MAIN', quantity: 100, amount: 500.00)
 *     ->addRawMaterial('RAW001', warehouse: 'MAIN', quantity: 200)
 *     ->addRawMaterial('RAW002', warehouse: 'MAIN', quantity: 50)
 *     ->addProductionService('SVC001', amount: 100.00, quantity: 1)
 *     ->save('PRODUCTION');
 * ```
 *
 * Every line type defaults nPirmasMat to 1 (quantity in the first unit), as on
 * ProductLine; pass ['nPirmasMat' => 0] in $additionalData to opt out.
 */
final class ProductionBuilder extends OperationBuilder
{
    use SetsClient;
    use SetsDocumentNumber;
    use SetsEmployeeByName;
    use SetsMarked;
    use SetsNote;

    /** @var array<int, array<string, mixed>> */
    protected array $finishedGoods = [];

    /** @var array<int, array<string, mixed>> */
    protected array $rawMaterials = [];

    /** @var array<int, array<string, mixed>> */
    protected array $productionServices = [];

    public function getOperationClass(): OperationClass
    {
        return OperationClass::Production;
    }

    protected function lineMethodHint(): string
    {
        return 'addFinishedGood()/addRawMaterial()/addProductionService()';
    }

    /**
     * Build the complete operation data array.
     *
     * Detail rows (finished goods, raw materials, services) are nested inside
     * the GamybaDok wrapper, consistent with all other operation classes.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $payload = $this->header;

        if (! empty($this->finishedGoods)) {
            $payload['GamybaGDetEil'] = $this->finishedGoods;
        }

        if (! empty($this->rawMaterials)) {
            $payload['GamybaZDetEil'] = $this->rawMaterials;
        }

        if (! empty($this->productionServices)) {
            $payload['GamybaPDetEil'] = $this->productionServices;
        }

        return [$this->getHeaderKey() => $payload];
    }

    // --- Production-specific methods ---

    /**
     * Set the main product/finished goods code (sGaminys).
     */
    public function finishedProduct(string $code): self
    {
        $this->header['sGaminys'] = $code;

        return $this;
    }

    /**
     * Set the production quantity (dKiekis).
     */
    public function quantity(float $quantity): self
    {
        $this->header['dKiekis'] = $quantity;

        return $this;
    }

    /**
     * Set the description (sAprasymas).
     */
    public function description(string $description): self
    {
        $this->header['sAprasymas'] = $description;

        return $this;
    }

    /**
     * Set the second description line (sAprasymas2).
     */
    public function description2(string $description): self
    {
        $this->header['sAprasymas2'] = $description;

        return $this;
    }

    /**
     * Set the transfer flag (nPerkelta).
     */
    public function transferred(bool $transferred = true): self
    {
        $this->header['nPerkelta'] = $transferred ? 1 : 0;

        return $this;
    }

    /**
     * Add a finished goods line (GamybaGDetEil).
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addFinishedGood(
        string $code,
        string $warehouse,
        float $quantity,
        ?float $amount = null,
        array $additionalData = [],
    ): self {
        $line = array_merge([
            'sKodas' => $code,
            'sSandelis' => $warehouse,
            'nKiekis' => $quantity,
            'nPirmasMat' => 1,
        ], $additionalData);

        if ($amount !== null) {
            $line['dSuma'] = $amount;
        }

        $this->finishedGoods[] = $line;

        return $this;
    }

    /**
     * Add a raw material line (GamybaZDetEil).
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addRawMaterial(
        string $code,
        string $warehouse,
        float $quantity,
        array $additionalData = [],
    ): self {
        $this->rawMaterials[] = array_merge([
            'sKodas' => $code,
            'sSandelis' => $warehouse,
            'nKiekis' => $quantity,
            'nPirmasMat' => 1,
        ], $additionalData);

        return $this;
    }

    /**
     * Add a production service line (GamybaPDetEil).
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addProductionService(
        string $code,
        float $amount,
        float $quantity,
        array $additionalData = [],
    ): self {
        $this->productionServices[] = array_merge([
            'sKodas' => $code,
            'dSuma' => $amount,
            'nKiekis' => $quantity,
            'nPirmasMat' => 1,
        ], $additionalData);

        return $this;
    }
}
