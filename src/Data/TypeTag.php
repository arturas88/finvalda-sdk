<?php

declare(strict_types=1);

namespace Finvalda\Data;

/**
 * A single row from a type/tag dictionary (rūšys ir požymiai).
 *
 * Returned by Products/Clients/Services::typesAndTags() and allTypesAndTags().
 * Each row carries a `tipas` discriminator that tells you whether it is a Type
 * or one of the Tag groups — the request-side `nID` parameter is ignored by the
 * server, so the dictionary is filtered client-side by `tipas` instead.
 *
 * Columns (exact lowercase keys, verified against the live server):
 * clients/services return [tipas, kodas, pavadinimas]; products additionally
 * return [info1, info2]. `tipas` arrives as an integer.
 */
final class TypeTag extends Entity
{
    public function __construct(
        public readonly int $tipas,
        public readonly string $code,
        public readonly string $name,
        public readonly ?string $info1 = null,
        public readonly ?string $info2 = null,
        array $raw = [],
    ) {
        $this->raw = $raw;
    }

    public static function fromArray(array $data): static
    {
        return new self(
            tipas: (int) ($data['tipas'] ?? 0),
            code: (string) ($data['kodas'] ?? ''),
            name: (string) ($data['pavadinimas'] ?? ''),
            info1: isset($data['info1']) ? (string) $data['info1'] : null,
            info2: isset($data['info2']) ? (string) $data['info2'] : null,
            raw: $data,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'tipas' => $this->tipas,
            'kodas' => $this->code,
            'pavadinimas' => $this->name,
            'info1' => $this->info1,
            'info2' => $this->info2,
        ], fn ($v) => $v !== null);
    }
}
