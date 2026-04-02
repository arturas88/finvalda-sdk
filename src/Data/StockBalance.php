<?php

declare(strict_types=1);

namespace Finvalda\Data;

/**
 * Stock/inventory balance entity DTO.
 */
final class StockBalance extends Entity
{
    public function __construct(
        public readonly string $productCode,
        public readonly ?string $productName = null,
        public readonly ?string $warehouseCode = null,
        public readonly ?string $warehouseName = null,
        public readonly ?float $quantity = null,
        public readonly ?string $measureUnit = null,
        public readonly ?float $price = null,
        public readonly ?float $costPrice = null,
        public readonly ?float $totalValue = null,
        public readonly ?string $currency = null,
        array $raw = [],
    ) {
        $this->raw = $raw;
    }

    public static function fromArray(array $data): static
    {
        return new self(
            productCode: (string) ($data['sPrekesKodas'] ?? $data['preke'] ?? ''),
            productName: $data['sPrekesPav'] ?? $data['prekes_pav'] ?? null,
            warehouseCode: $data['sSandelioKodas'] ?? $data['sandelis'] ?? null,
            warehouseName: $data['sSandelioPav'] ?? $data['sandelio_pav'] ?? null,
            quantity: isset($data['dKiekis']) ? (float) $data['dKiekis'] : (isset($data['kiekis']) ? (float) $data['kiekis'] : null),
            measureUnit: $data['sMatVnt'] ?? $data['mato_vnt'] ?? null,
            price: isset($data['dKaina']) ? (float) $data['dKaina'] : (isset($data['kaina']) ? (float) $data['kaina'] : null),
            costPrice: isset($data['dSavikaina']) ? (float) $data['dSavikaina'] : (isset($data['savikaina']) ? (float) $data['savikaina'] : null),
            totalValue: isset($data['dSuma']) ? (float) $data['dSuma'] : (isset($data['suma']) ? (float) $data['suma'] : null),
            currency: $data['sValiuta'] ?? $data['valiuta'] ?? null,
            raw: $data,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'sPrekesKodas' => $this->productCode,
            'sPrekesPav' => $this->productName,
            'sSandelioKodas' => $this->warehouseCode,
            'sSandelioPav' => $this->warehouseName,
            'dKiekis' => $this->quantity,
            'sMatVnt' => $this->measureUnit,
            'dKaina' => $this->price,
            'dSavikaina' => $this->costPrice,
            'dSuma' => $this->totalValue,
            'sValiuta' => $this->currency,
        ], fn ($v) => $v !== null);
    }
}
