<?php

declare(strict_types=1);

namespace Finvalda\Data;

/**
 * Service entity DTO.
 */
final class Service extends Entity
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly ?float $price = null,
        public readonly ?float $buyPrice = null,
        public readonly ?float $sellPrice = null,
        public readonly ?string $barcode = null,
        public readonly ?string $currency = null,
        public readonly ?string $measureUnit = null,
        public readonly ?string $type = null,
        public readonly ?string $tag1 = null,
        public readonly ?string $tag2 = null,
        public readonly ?string $tag3 = null,
        public readonly ?string $accountLink = null,
        public readonly ?string $taxCode = null,
        public readonly ?bool $active = null,
        public readonly ?string $createdAt = null,
        public readonly ?string $updatedAt = null,
        array $raw = [],
    ) {
        $this->raw = $raw;
    }

    public static function fromArray(array $data): static
    {
        return new self(
            code: (string) ($data['sKodas'] ?? $data['paslauga'] ?? ''),
            name: (string) ($data['sPavadinimas'] ?? $data['paslaugos_pav'] ?? ''),
            price: isset($data['dKaina']) ? (float) $data['dKaina']
                : (isset($data['kaina']) ? (float) $data['kaina']
                : (isset($data['dPardavimoKaina']) ? (float) $data['dPardavimoKaina'] : null)),
            buyPrice: isset($data['dPirkimoKaina']) ? (float) $data['dPirkimoKaina'] : null,
            sellPrice: isset($data['dPardavimoKaina']) ? (float) $data['dPardavimoKaina'] : null,
            barcode: $data['sBARKodas'] ?? $data['bar_kodas'] ?? null,
            currency: $data['sValiuta'] ?? $data['valiuta'] ?? null,
            measureUnit: $data['sMatVnt'] ?? $data['mato_vnt'] ?? $data['sMatVienetas'] ?? null,
            type: $data['sRusis'] ?? $data['rusis'] ?? null,
            tag1: $data['sPozymis1'] ?? $data['pozymis1'] ?? null,
            tag2: $data['sPozymis2'] ?? $data['pozymis2'] ?? null,
            tag3: $data['sPozymis3'] ?? $data['pozymis3'] ?? null,
            accountLink: $data['sRysysSuSask'] ?? null,
            taxCode: $data['sMokestis'] ?? null,
            active: isset($data['nAktyvi']) ? (bool) $data['nAktyvi'] : null,
            createdAt: $data['tKurimoData'] ?? $data['kurimo_data'] ?? null,
            updatedAt: $data['tKoregavimoData'] ?? $data['koregavimo_data'] ?? null,
            raw: $data,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'sKodas' => $this->code,
            'sPavadinimas' => $this->name,
            'dKaina' => $this->price,
            'dPirkimoKaina' => $this->buyPrice,
            'dPardavimoKaina' => $this->sellPrice,
            'sBARKodas' => $this->barcode,
            'sValiuta' => $this->currency,
            'sMatVnt' => $this->measureUnit,
            'sRusis' => $this->type,
            'sPozymis1' => $this->tag1,
            'sPozymis2' => $this->tag2,
            'sPozymis3' => $this->tag3,
            'sRysysSuSask' => $this->accountLink,
            'sMokestis' => $this->taxCode,
            'nAktyvi' => $this->active === null ? null : (int) $this->active,
            'tKurimoData' => $this->createdAt,
            'tKoregavimoData' => $this->updatedAt,
        ], fn ($v) => $v !== null);
    }
}
