<?php

declare(strict_types=1);

namespace Finvalda\Data;

/**
 * Product entity DTO.
 */
final class Product extends Entity
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly ?string $measureUnit = null,
        public readonly ?string $measureUnitName = null,
        public readonly ?float $quantity = null,
        public readonly ?float $price1 = null,
        public readonly ?float $price2 = null,
        public readonly ?float $price3 = null,
        public readonly ?float $price4 = null,
        public readonly ?float $price5 = null,
        public readonly ?float $price6 = null,
        public readonly ?string $currency = null,
        public readonly ?float $costPrice = null,
        public readonly ?string $type = null,
        public readonly ?string $tag1 = null,
        public readonly ?string $tag2 = null,
        public readonly ?string $tag3 = null,
        public readonly ?string $tag4 = null,
        public readonly ?string $tag5 = null,
        public readonly ?string $tag6 = null,
        public readonly ?string $supplier1 = null,
        public readonly ?string $supplier2 = null,
        public readonly ?string $supplier3 = null,
        public readonly ?string $barcode = null,
        public readonly ?string $accountLink = null,
        public readonly ?string $taxCode = null,
        array $raw = [],
    ) {
        $this->raw = $raw;
    }

    public static function fromArray(array $data): static
    {
        return new self(
            code: (string) ($data['sKodas'] ?? $data['preke'] ?? ''),
            name: (string) ($data['sPavadinimas'] ?? $data['prekes_pav'] ?? ''),
            measureUnit: $data['sMatVnt'] ?? $data['mato_vnt'] ?? null,
            measureUnitName: $data['sMatVntPav'] ?? $data['mato_vnt_pav'] ?? null,
            quantity: isset($data['dKiekis']) ? (float) $data['dKiekis'] : (isset($data['kiekis']) ? (float) $data['kiekis'] : null),
            price1: isset($data['dKaina1']) ? (float) $data['dKaina1'] : (isset($data['kaina1']) ? (float) $data['kaina1'] : null),
            price2: isset($data['dKaina2']) ? (float) $data['dKaina2'] : (isset($data['kaina2']) ? (float) $data['kaina2'] : null),
            price3: isset($data['dKaina3']) ? (float) $data['dKaina3'] : (isset($data['kaina3']) ? (float) $data['kaina3'] : null),
            price4: isset($data['dKaina4']) ? (float) $data['dKaina4'] : (isset($data['kaina4']) ? (float) $data['kaina4'] : null),
            price5: isset($data['dKaina5']) ? (float) $data['dKaina5'] : (isset($data['kaina5']) ? (float) $data['kaina5'] : null),
            price6: isset($data['dKaina6']) ? (float) $data['dKaina6'] : (isset($data['kaina6']) ? (float) $data['kaina6'] : null),
            currency: $data['sValiuta'] ?? $data['valiuta'] ?? null,
            costPrice: isset($data['dSavikaina']) ? (float) $data['dSavikaina'] : (isset($data['savikaina']) ? (float) $data['savikaina'] : null),
            type: $data['sRusis'] ?? $data['rusis'] ?? null,
            tag1: $data['sPozymis1'] ?? $data['pozymis1'] ?? null,
            tag2: $data['sPozymis2'] ?? $data['pozymis2'] ?? null,
            tag3: $data['sPozymis3'] ?? $data['pozymis3'] ?? null,
            tag4: $data['sPozymis4'] ?? $data['pozymis4'] ?? null,
            tag5: $data['sPozymis5'] ?? $data['pozymis5'] ?? null,
            tag6: $data['sPozymis6'] ?? $data['pozymis6'] ?? null,
            supplier1: $data['sTiekejas1'] ?? $data['tiekejas1'] ?? null,
            supplier2: $data['sTiekejas2'] ?? $data['tiekejas2'] ?? null,
            supplier3: $data['sTiekejas3'] ?? $data['tiekejas3'] ?? null,
            barcode: $data['sBruksnKodas'] ?? $data['barcode'] ?? null,
            accountLink: $data['sRysysSuSask'] ?? null,
            taxCode: $data['sMokestis'] ?? null,
            raw: $data,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'sKodas' => $this->code,
            'sPavadinimas' => $this->name,
            'sMatVnt' => $this->measureUnit,
            'dKaina1' => $this->price1,
            'dKaina2' => $this->price2,
            'dKaina3' => $this->price3,
            'dKaina4' => $this->price4,
            'dKaina5' => $this->price5,
            'dKaina6' => $this->price6,
            'sValiuta' => $this->currency,
            'sRusis' => $this->type,
            'sPozymis1' => $this->tag1,
            'sPozymis2' => $this->tag2,
            'sPozymis3' => $this->tag3,
            'sPozymis4' => $this->tag4,
            'sPozymis5' => $this->tag5,
            'sPozymis6' => $this->tag6,
            'sTiekejas1' => $this->supplier1,
            'sTiekejas2' => $this->supplier2,
            'sTiekejas3' => $this->supplier3,
            'sBruksnKodas' => $this->barcode,
            'sRysysSuSask' => $this->accountLink,
            'sMokestis' => $this->taxCode,
        ], fn ($v) => $v !== null);
    }
}
