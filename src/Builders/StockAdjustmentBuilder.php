<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Builders\Concerns\HasDefaultWarehouse;
use Finvalda\Builders\Concerns\SetsClient;
use Finvalda\Builders\Concerns\SetsDocumentNumber;
use Finvalda\Builders\Concerns\SetsEmployee;
use Finvalda\Builders\Concerns\SetsMarked;
use Finvalda\Builders\Concerns\SetsName;
use Finvalda\Builders\Concerns\SetsNote;

/**
 * Shared shape of write-offs (NurasymasDok) and capitalizations
 * (PajamavimasDok): one header table, and detail lines that carry their own
 * warehouse and account. Lines are added with the subclass's addItem().
 */
abstract class StockAdjustmentBuilder extends OperationBuilder
{
    use HasDefaultWarehouse;
    use SetsClient;
    use SetsDocumentNumber;
    use SetsEmployee;
    use SetsMarked;
    use SetsName;
    use SetsNote;

    /** @var array<int, array<string, mixed>> */
    protected array $items = [];

    protected function lineMethodHint(): string
    {
        return 'addItem()';
    }

    /**
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $data = parent::build();

        if ($this->items !== []) {
            $data[$this->getHeaderKey()][$this->getHeaderKey() . 'DetEil'] = $this->withDefaultWarehouse($this->items);
        }

        return $data;
    }

    /**
     * nPirmasMat defaults to 1 so nKiekis is read in the product's first
     * (primary) unit, as on ProductLine; pass ['nPirmasMat' => 0] in
     * $additionalData to opt out.
     *
     * @param  array<string, mixed>  $additionalData
     */
    protected function addStockLine(
        string $code,
        float $quantity,
        ?string $warehouse,
        ?string $account,
        array $additionalData,
    ): static {
        $line = ['sKodas' => $code, 'nKiekis' => $quantity, 'nPirmasMat' => 1];

        if ($warehouse !== null) {
            $line['sSandelis'] = $warehouse;
        }

        if ($account !== null) {
            $line['sSaskaita'] = $account;
        }

        $this->items[] = array_merge($line, $additionalData);

        return $this;
    }
}
