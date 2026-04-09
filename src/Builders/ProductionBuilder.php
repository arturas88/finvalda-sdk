<?php

declare(strict_types=1);

namespace Finvalda\Builders;

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
 *     ->product('FINISHED001')
 *     ->documentNumber('PROD-001')
 *     ->description('Daily production run')
 *     ->addFinishedGood('FINISHED001', warehouse: 'MAIN', quantity: 100, amount: 500.00)
 *     ->addRawMaterial('RAW001', warehouse: 'MAIN', quantity: 200)
 *     ->addRawMaterial('RAW002', warehouse: 'MAIN', quantity: 50)
 *     ->addProductionService('SVC001', amount: 100.00, quantity: 1)
 *     ->save('PRODUCTION');
 * ```
 */
final class ProductionBuilder extends OperationBuilder
{
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

    protected function getHeaderKey(): string
    {
        return 'GamybaDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'GamybaGDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        return 'GamybaPDetEil';
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

        if (! empty($this->finishedGoods)) {
            $data['GamybaGDetEil'] = $this->finishedGoods;
        }

        if (! empty($this->rawMaterials)) {
            $data['GamybaZDetEil'] = $this->rawMaterials;
        }

        if (! empty($this->productionServices)) {
            $data['GamybaPDetEil'] = $this->productionServices;
        }

        return $data;
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
     * Set the production quantity.
     */
    public function quantity(float $quantity): self
    {
        $this->header['dKiekis'] = $quantity;

        return $this;
    }

    /**
     * Set the second description line.
     */
    public function description2(string $description): self
    {
        $this->header['sAprasymas2'] = $description;

        return $this;
    }

    /**
     * Set a note/comment.
     */
    public function note(string $note): self
    {
        $this->header['sPastaba'] = $note;

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
     * Set the transfer flag.
     */
    public function transferred(bool $transferred = true): self
    {
        $this->header['nPerkelta'] = $transferred ? 1 : 0;

        return $this;
    }

    /**
     * Set the marked/flagged status.
     */
    public function marked(bool $marked = true): self
    {
        $this->header['nPozymis'] = $marked ? 1 : 0;

        return $this;
    }

    /**
     * Add a finished goods line.
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
        ], $additionalData);

        if ($amount !== null) {
            $line['dSuma'] = $amount;
        }

        $this->finishedGoods[] = $line;

        return $this;
    }

    /**
     * Add a raw material line.
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
        ], $additionalData);

        return $this;
    }

    /**
     * Add a production service line.
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
        ], $additionalData);

        return $this;
    }
}
