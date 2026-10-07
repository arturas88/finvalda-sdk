<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Builders\Concerns\SetsClient;
use Finvalda\Builders\Concerns\SetsDocumentNumber;
use Finvalda\Builders\Concerns\SetsEmployee;
use Finvalda\Builders\Concerns\SetsMarked;
use Finvalda\Builders\Concerns\SetsName;
use Finvalda\Builders\Concerns\SetsNote;
use Finvalda\Enums\OperationClass;
use Finvalda\Exceptions\ValidationException;

/**
 * Fluent builder for internal transfer operations (VidPerkDok).
 *
 * Usage:
 * ```php
 * $result = $finvalda->internalTransfer()
 *     ->date('2024-01-15')
 *     ->fromWarehouse('MAIN')
 *     ->toWarehouse('BRANCH')
 *     ->addTransfer('PRD001', quantity: 50)
 *     ->addTransfer('PRD002', quantity: 25)
 *     ->save('TRANSFER');
 * ```
 */
final class InternalTransferBuilder extends OperationBuilder
{
    use SetsClient;
    use SetsDocumentNumber;
    use SetsEmployee;
    use SetsMarked;
    use SetsName;
    use SetsNote;

    /** @var array<int, array<string, mixed>> */
    private array $transfers = [];

    public function getOperationClass(): OperationClass
    {
        return OperationClass::InternalTransfer;
    }

    protected function lineMethodHint(): string
    {
        return 'addTransfer()';
    }

    /**
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $data = parent::build();

        if ($this->transfers !== []) {
            $data['VidPerkDok']['VidPerkDokDetEil'] = $this->transfers;
        }

        return $data;
    }

    /**
     * Set the source warehouse code (sIsSandelio).
     */
    public function fromWarehouse(string $warehouseCode): self
    {
        $this->header['sIsSandelio'] = $warehouseCode;

        return $this;
    }

    /**
     * Set the destination warehouse code (sISandeli).
     */
    public function toWarehouse(string $warehouseCode): self
    {
        $this->header['sISandeli'] = $warehouseCode;

        return $this;
    }

    /**
     * Set the document series (sSerija).
     */
    public function series(string $series): self
    {
        $this->header['sSerija'] = $series;

        return $this;
    }

    /**
     * Set whether to export to iVAZ (nIVAZ).
     */
    public function exportToIvaz(bool $export = true): self
    {
        $this->header['nIVAZ'] = $export ? 1 : 0;

        return $this;
    }

    /**
     * Add a product transfer line.
     *
     * A transfer moves every line between ONE warehouse pair, held on the header
     * (sIsSandelio/sISandeli); VidPerkDokDetEil has no warehouse fields.
     * $fromWarehouse/$toWarehouse set that pair, and a value that contradicts
     * one already set throws instead of silently re-routing earlier lines.
     *
     * nPirmasMat defaults to 1 (quantity in the product's first unit), as on
     * ProductLine; pass ['nPirmasMat' => 0] in $additionalData to opt out.
     *
     * @param  array<string, mixed>  $additionalData  Further VidPerkDokDetEil fields
     *
     * @throws ValidationException  When a warehouse contradicts the one already set.
     */
    public function addTransfer(
        string $productCode,
        float $quantity,
        ?string $fromWarehouse = null,
        ?string $toWarehouse = null,
        array $additionalData = [],
    ): self {
        $this->setWarehouseOnce('sIsSandelio', $fromWarehouse);
        $this->setWarehouseOnce('sISandeli', $toWarehouse);

        $this->transfers[] = array_merge([
            'sKodas' => $productCode,
            'nKiekis' => $quantity,
            'nPirmasMat' => 1,
        ], $additionalData);

        return $this;
    }

    /**
     * @throws ValidationException
     */
    private function setWarehouseOnce(string $key, ?string $warehouse): void
    {
        if ($warehouse === null) {
            return;
        }

        $current = $this->header[$key] ?? null;

        if ($current !== null && $current !== $warehouse) {
            throw new ValidationException(
                "A transfer has one {$key} for all lines: '{$current}' is already set, '{$warehouse}' given"
            );
        }

        $this->header[$key] = $warehouse;
    }
}
