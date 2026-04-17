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
        public readonly ?string $barcode = null,
        public readonly ?float $quantity = null,
        public readonly ?float $quantityReserved = null,
        public readonly ?string $measureUnit = null,
        public readonly ?float $measurementRatio = null,
        public readonly ?float $price = null,
        public readonly ?float $costPrice = null,
        public readonly ?float $totalValue = null,
        public readonly ?string $currency = null,
        public readonly ?string $type = null,
        public readonly ?string $tag1 = null,
        public readonly ?string $tag2 = null,
        public readonly ?string $tag3 = null,
        public readonly ?string $tag4 = null,
        public readonly ?string $tag5 = null,
        public readonly ?string $tag6 = null,
        public readonly ?string $orderDate = null,
        public readonly ?float $warehousePrice1 = null,
        public readonly ?float $warehousePrice2 = null,
        public readonly ?float $warehousePrice3 = null,
        public readonly ?float $warehousePrice4 = null,
        public readonly ?float $warehousePrice5 = null,
        public readonly ?float $warehousePrice6 = null,
        public readonly ?string $warehousePriceCurrency = null,
        public readonly ?float $cardPrice1 = null,
        public readonly ?float $cardPrice2 = null,
        public readonly ?float $cardPrice3 = null,
        public readonly ?float $cardPrice4 = null,
        public readonly ?float $cardPrice5 = null,
        public readonly ?float $cardPrice6 = null,
        public readonly ?string $cardPriceCurrency = null,
        array $raw = [],
    ) {
        $this->raw = $raw;
    }

    public static function fromArray(array $data): static
    {
        $floatOrNull = static fn (string ...$keys): ?float => self::firstFloat($data, $keys);

        return new self(
            productCode: (string) ($data['sPrekesKodas'] ?? $data['preke'] ?? ''),
            productName: $data['sPrekesPav'] ?? $data['prekes_pav'] ?? null,
            warehouseCode: $data['sSandelioKodas'] ?? $data['sandelis'] ?? null,
            warehouseName: $data['sSandelioPav'] ?? $data['sandelio_pav'] ?? null,
            barcode: $data['sBarKodas'] ?? $data['barkodas'] ?? null,
            quantity: $floatOrNull('dKiekis', 'kiekis'),
            quantityReserved: $floatOrNull('dKiekisSuRezervuotom', 'kiekis_su_rezervuotom'),
            measureUnit: $data['sMatVnt'] ?? $data['mato_vnt_pav'] ?? $data['mato_vnt'] ?? null,
            measurementRatio: $floatOrNull('dPirmAntrMatSant', 'pirm_antr_mat_sant'),
            price: $floatOrNull('dKaina', 'kaina'),
            costPrice: $floatOrNull('dSavikaina', 'savikaina'),
            totalValue: $floatOrNull('dSuma', 'suma'),
            currency: $data['sValiuta'] ?? $data['valiuta'] ?? null,
            type: $data['sRusis'] ?? $data['rusis'] ?? null,
            tag1: $data['sPozymis1'] ?? $data['pozymis1'] ?? null,
            tag2: $data['sPozymis2'] ?? $data['pozymis2'] ?? null,
            tag3: $data['sPozymis3'] ?? $data['pozymis3'] ?? null,
            tag4: $data['sPozymis4'] ?? $data['pozymis4'] ?? null,
            tag5: $data['sPozymis5'] ?? $data['pozymis5'] ?? null,
            tag6: $data['sPozymis6'] ?? $data['pozymis6'] ?? null,
            orderDate: $data['tUzsakData'] ?? $data['uzsak_data'] ?? null,
            warehousePrice1: $floatOrNull('dKaina1San', 'kaina1_san'),
            warehousePrice2: $floatOrNull('dKaina2San', 'kaina2_san'),
            warehousePrice3: $floatOrNull('dKaina3San', 'kaina3_san'),
            warehousePrice4: $floatOrNull('dKaina4San', 'kaina4_san'),
            warehousePrice5: $floatOrNull('dKaina5San', 'kaina5_san'),
            warehousePrice6: $floatOrNull('dKaina6San', 'kaina6_san'),
            warehousePriceCurrency: $data['sValiutaSan'] ?? $data['valiuta_san'] ?? null,
            cardPrice1: $floatOrNull('dKaina1Kort', 'kaina1_kort'),
            cardPrice2: $floatOrNull('dKaina2Kort', 'kaina2_kort'),
            cardPrice3: $floatOrNull('dKaina3Kort', 'kaina3_kort'),
            cardPrice4: $floatOrNull('dKaina4Kort', 'kaina4_kort'),
            cardPrice5: $floatOrNull('dKaina5Kort', 'kaina5_kort'),
            cardPrice6: $floatOrNull('dKaina6Kort', 'kaina6_kort'),
            cardPriceCurrency: $data['sValiutaKort'] ?? $data['valiuta_kort'] ?? null,
            raw: $data,
        );
    }

    private static function firstFloat(array $data, array $keys): ?float
    {
        foreach ($keys as $k) {
            if (isset($data[$k])) {
                return (float) $data[$k];
            }
        }

        return null;
    }

    public function toArray(): array
    {
        return array_filter([
            'sPrekesKodas' => $this->productCode,
            'sPrekesPav' => $this->productName,
            'sSandelioKodas' => $this->warehouseCode,
            'sSandelioPav' => $this->warehouseName,
            'sBarKodas' => $this->barcode,
            'dKiekis' => $this->quantity,
            'dKiekisSuRezervuotom' => $this->quantityReserved,
            'sMatVnt' => $this->measureUnit,
            'dPirmAntrMatSant' => $this->measurementRatio,
            'dKaina' => $this->price,
            'dSavikaina' => $this->costPrice,
            'dSuma' => $this->totalValue,
            'sValiuta' => $this->currency,
            'sRusis' => $this->type,
            'sPozymis1' => $this->tag1,
            'sPozymis2' => $this->tag2,
            'sPozymis3' => $this->tag3,
            'sPozymis4' => $this->tag4,
            'sPozymis5' => $this->tag5,
            'sPozymis6' => $this->tag6,
            'tUzsakData' => $this->orderDate,
            'dKaina1San' => $this->warehousePrice1,
            'dKaina2San' => $this->warehousePrice2,
            'dKaina3San' => $this->warehousePrice3,
            'dKaina4San' => $this->warehousePrice4,
            'dKaina5San' => $this->warehousePrice5,
            'dKaina6San' => $this->warehousePrice6,
            'sValiutaSan' => $this->warehousePriceCurrency,
            'dKaina1Kort' => $this->cardPrice1,
            'dKaina2Kort' => $this->cardPrice2,
            'dKaina3Kort' => $this->cardPrice3,
            'dKaina4Kort' => $this->cardPrice4,
            'dKaina5Kort' => $this->cardPrice5,
            'dKaina6Kort' => $this->cardPrice6,
            'sValiutaKort' => $this->cardPriceCurrency,
        ], fn ($v) => $v !== null);
    }
}
