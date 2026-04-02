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
        public readonly ?string $description = null,
        public readonly ?bool $active = null,
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

        $codeKey = "sObj{$level}Kod";
        $altCodeKey = "obj{$level}_kodas";

        return new self(
            level: $level,
            code: (string) ($data['sKodas'] ?? $data[$codeKey] ?? $data[$altCodeKey] ?? $data['kodas'] ?? ''),
            name: (string) ($data['sPavadinimas'] ?? $data['pavadinimas'] ?? ''),
            description: $data['sAprasymas'] ?? $data['aprasymas'] ?? null,
            active: isset($data['bGaliojimas']) ? (bool) $data['bGaliojimas'] : (isset($data['galiojimas']) ? (bool) $data['galiojimas'] : null),
            raw: $data,
        );
    }

    /**
     * Create from array with explicit level.
     */
    public static function fromArrayWithLevel(array $data, int $level): static
    {
        return new self(
            level: $level,
            code: (string) ($data['sKodas'] ?? $data["sObj{$level}Kod"] ?? $data['kodas'] ?? ''),
            name: (string) ($data['sPavadinimas'] ?? $data['pavadinimas'] ?? ''),
            description: $data['sAprasymas'] ?? $data['aprasymas'] ?? null,
            active: isset($data['bGaliojimas']) ? (bool) $data['bGaliojimas'] : (isset($data['galiojimas']) ? (bool) $data['galiojimas'] : null),
            raw: $data,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'sKodas' => $this->code,
            'sPavadinimas' => $this->name,
            'sAprasymas' => $this->description,
            'bGaliojimas' => $this->active,
        ], fn ($v) => $v !== null);
    }
}
