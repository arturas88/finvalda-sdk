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
     * Set the source warehouse (sIsSandelio).
     */
    public function fromWarehouse(string $warehouseCode): self
    {
        $this->header['sIsSandelio'] = $warehouseCode;

        return $this;
    }

    /**
     * Set the destination warehouse (sISandeli).
     */
    public function toWarehouse(string $warehouseCode): self
    {
        $this->header['sISandeli'] = $warehouseCode;

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
     * Set whether to export to iVAZ.
     */
    public function exportToIvaz(bool $export = true): self
    {
        $this->header['nIVAZ'] = $export ? 1 : 0;

        return $this;
    }

    /**
     * Set the operation marked flag.
     */
    public function marked(bool $marked = true): self
    {
        $this->header['nPozymis'] = $marked ? 1 : 0;

        return $this;
    }

    /**
     * Set the Finvalda employee name.
     */
    public function employee(string $employee): self
    {
        $this->header['sDarbuotojas'] = $employee;

        return $this;
    }

    /**
     * Add a product transfer line.
     *
     * Internal transfers carry a single source/destination warehouse pair at
     * the header level (sIsSandelio/sISandeli); the detail rows (VidPerkDokDetEil)
     * have no per-line warehouse fields. For convenience, passing
     * $fromWarehouse/$toWarehouse here sets the header values (last call wins) —
     * prefer fromWarehouse()/toWarehouse() for clarity.
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
        if ($fromWarehouse !== null) {
            $this->fromWarehouse($fromWarehouse);
        }

        if ($toWarehouse !== null) {
            $this->toWarehouse($toWarehouse);
        }

        $this->productLines[] = array_merge([
            'sKodas' => $productCode,
            'nKiekis' => $quantity,
        ], $additionalData);

        return $this;
    }
}
