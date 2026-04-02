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
        public readonly ?string $currency = null,
        public readonly ?string $measureUnit = null,
        public readonly ?string $type = null,
        public readonly ?string $tag1 = null,
        public readonly ?string $tag2 = null,
        public readonly ?string $tag3 = null,
        public readonly ?string $accountLink = null,
        public readonly ?string $taxCode = null,
        array $raw = [],
    ) {
        $this->raw = $raw;
    }

    public static function fromArray(array $data): static
    {
        return new self(
            code: (string) ($data['sKodas'] ?? $data['paslauga'] ?? ''),
            name: (string) ($data['sPavadinimas'] ?? $data['paslaugos_pav'] ?? ''),
            price: isset($data['dKaina']) ? (float) $data['dKaina'] : (isset($data['kaina']) ? (float) $data['kaina'] : null),
            currency: $data['sValiuta'] ?? $data['valiuta'] ?? null,
            measureUnit: $data['sMatVnt'] ?? $data['mato_vnt'] ?? null,
            type: $data['sRusis'] ?? $data['rusis'] ?? null,
            tag1: $data['sPozymis1'] ?? $data['pozymis1'] ?? null,
            tag2: $data['sPozymis2'] ?? $data['pozymis2'] ?? null,
            tag3: $data['sPozymis3'] ?? $data['pozymis3'] ?? null,
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
            'dKaina' => $this->price,
            'sValiuta' => $this->currency,
            'sMatVnt' => $this->measureUnit,
            'sRusis' => $this->type,
            'sPozymis1' => $this->tag1,
            'sPozymis2' => $this->tag2,
            'sPozymis3' => $this->tag3,
            'sRysysSuSask' => $this->accountLink,
            'sMokestis' => $this->taxCode,
        ], fn ($v) => $v !== null);
    }
}
