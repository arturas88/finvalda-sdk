<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Enums\OperationClass;

/**
 * Fluent builder for internal transfer operations (VidPerkDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->internalTransfer()
 *     ->date('2024-01-15')
 *     ->fromWarehouse('MAIN')
 *     ->toWarehouse('BRANCH')
 *     ->addProduct('PRD001', quantity: 50)
 *     ->save('TRANSFER');
 * ```
 */
final class InternalTransferBuilder extends OperationBuilder
{
    public function getOperationClass(): OperationClass
    {
        return OperationClass::InternalTransfer;
    }

    protected function getHeaderKey(): string
    {
        return 'VidPerkDok';
    }

    protected function getProductLinesKey(): string
    {
        return 'VidPerkDokDetEil';
    }

    protected function getServiceLinesKey(): string
    {
        // Internal transfers don't typically have services
        return 'VidPerkDokPaslaugaDetEil';
    }

    // --- Transfer-specific methods ---

    /**
     * Set the source warehouse.
     */
    public function fromWarehouse(string $warehouseCode): self
    {
        $this->header['sSandIs'] = $warehouseCode;

        return $this;
    }

    /**
     * Set the destination warehouse.
     */
    public function toWarehouse(string $warehouseCode): self
    {
        $this->header['sSandI'] = $warehouseCode;

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
     * Add a product transfer line.
     *
     * @param  array<string, mixed>  $additionalData
     */
    public function addTransfer(
        string $productCode,
        float $quantity,
        ?string $fromWarehouse = null,
        ?string $toWarehouse = null,
        array $additionalData = [],
    ): self {
        $line = array_merge([
            'sKodas' => $productCode,
            'nKiekis' => $quantity,
        ], $additionalData);

        if ($fromWarehouse !== null) {
            $line['sSandIs'] = $fromWarehouse;
        }

        if ($toWarehouse !== null) {
            $line['sSandI'] = $toWarehouse;
        }

        $this->productLines[] = $line;

        return $this;
    }
}
