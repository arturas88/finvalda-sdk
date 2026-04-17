<?php

declare(strict_types=1);

namespace Finvalda\Data;

/**
 * Analytical object entity DTO (levels 1-6).
 */
final class AnalyticalObject extends Entity
{
    public function __construct(
        public readonly int $level,
        public readonly string $code,
        public readonly string $name,
        public readonly ?string $name2 = null,
        public readonly ?string $description = null,
        public readonly ?string $type = null,
        public readonly ?string $tag1 = null,
        public readonly ?string $tag2 = null,
        public readonly ?string $tag3 = null,
        public readonly ?string $tag = null,
        public readonly ?string $groups = null,
        public readonly ?string $info1 = null,
        public readonly ?string $info2 = null,
        public readonly ?string $info3 = null,
        public readonly ?string $info4 = null,
        public readonly ?string $info5 = null,
        public readonly ?string $info6 = null,
        public readonly ?string $info7 = null,
        public readonly ?string $info8 = null,
        public readonly ?string $info9 = null,
        public readonly ?string $info10 = null,
        public readonly ?string $validFrom = null,
        public readonly ?string $validTo = null,
        public readonly ?bool $active = null,
        public readonly ?bool $isNew = null,
        array $raw = [],
    ) {
        $this->raw = $raw;
    }

    public static function fromArray(array $data): static
    {
        // Determine level from data keys
        $level = 1;
        for ($i = 1; $i <= 6; $i++) {
            if (isset($data["sObj{$i}Kod"]) || isset($data["obj{$i}_kodas"])) {
                $level = $i;
                break;
            }
        }

        return self::build($data, $level);
    }

    /**
     * Create from array with explicit level.
     */
    public static function fromArrayWithLevel(array $data, int $level): static
    {
        return self::build($data, $level);
    }

    private static function build(array $data, int $level): self
    {
        $codeKey = "sObj{$level}Kod";
        $altCodeKey = "obj{$level}_kodas";

        return new self(
            level: $level,
            code: (string) ($data['sKodas'] ?? $data[$codeKey] ?? $data[$altCodeKey] ?? $data['kodas'] ?? ''),
            name: (string) ($data['sPavadinimas'] ?? $data['pavadinimas'] ?? ''),
            name2: $data['sPavadinimas2'] ?? $data['pavadinimas2'] ?? null,
            description: $data['sAprasymas'] ?? $data['aprasymas'] ?? null,
            type: $data['sRusis'] ?? $data['rusis'] ?? null,
            tag1: $data['sPozymis1'] ?? $data['pozymis1'] ?? null,
            tag2: $data['sPozymis2'] ?? $data['pozymis2'] ?? null,
            tag3: $data['sPozymis3'] ?? $data['pozymis3'] ?? null,
            tag: $data['sPozymis'] ?? $data['pozymis'] ?? null,
            groups: $data['sGrupes'] ?? $data['grupes'] ?? null,
            info1: $data['sPapildomaInf1'] ?? $data['info1'] ?? null,
            info2: $data['sPapildomaInf2'] ?? $data['info2'] ?? null,
            info3: $data['sPapildomaInf3'] ?? $data['info3'] ?? null,
            info4: $data['sPapildomaInf4'] ?? $data['info4'] ?? null,
            info5: $data['sPapildomaInf5'] ?? $data['info5'] ?? null,
            info6: $data['sPapildomaInf6'] ?? $data['info6'] ?? null,
            info7: $data['sPapildomaInf7'] ?? $data['info7'] ?? null,
            info8: $data['sPapildomaInf8'] ?? $data['info8'] ?? null,
            info9: $data['sPapildomaInf9'] ?? $data['info9'] ?? null,
            info10: $data['sPapildomaInf10'] ?? $data['info10'] ?? null,
            validFrom: $data['tGaliojaNuo'] ?? $data['galioja_nuo'] ?? null,
            validTo: $data['tGaliojaIki'] ?? $data['galioja_iki'] ?? null,
            active: isset($data['bGaliojimas']) ? (bool) $data['bGaliojimas']
                : (isset($data['galiojimas']) ? (bool) $data['galiojimas'] : null),
            isNew: isset($data['bNaujas']) ? (bool) $data['bNaujas']
                : (isset($data['naujas']) ? (bool) $data['naujas'] : null),
            raw: $data,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'sKodas' => $this->code,
            'sPavadinimas' => $this->name,
            'sPavadinimas2' => $this->name2,
            'sAprasymas' => $this->description,
            'sRusis' => $this->type,
            'sPozymis1' => $this->tag1,
            'sPozymis2' => $this->tag2,
            'sPozymis3' => $this->tag3,
            'sPozymis' => $this->tag,
            'sGrupes' => $this->groups,
            'sPapildomaInf1' => $this->info1,
            'sPapildomaInf2' => $this->info2,
            'sPapildomaInf3' => $this->info3,
            'sPapildomaInf4' => $this->info4,
            'sPapildomaInf5' => $this->info5,
            'sPapildomaInf6' => $this->info6,
            'sPapildomaInf7' => $this->info7,
            'sPapildomaInf8' => $this->info8,
            'sPapildomaInf9' => $this->info9,
            'sPapildomaInf10' => $this->info10,
            'tGaliojaNuo' => $this->validFrom,
            'tGaliojaIki' => $this->validTo,
            'bGaliojimas' => $this->active === null ? null : (int) $this->active,
            'bNaujas' => $this->isNew === null ? null : (int) $this->isNew,
        ], fn ($v) => $v !== null);
    }
}
