<?php

declare(strict_types=1);

namespace Finvalda\Collections;

use BackedEnum;
use Finvalda\Data\TypeTag;

/**
 * Typed collection of TypeTag rows (the full rūšys ir požymiai dictionary).
 *
 * @extends Collection<TypeTag>
 */
final class TypeTagCollection extends Collection
{
    /**
     * @param  array<int, TypeTag>  $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    public static function fromArray(array $data): static
    {
        return new self(array_map(
            fn (array $item) => TypeTag::fromArray($item),
            array_values(array_filter($data, 'is_array'))
        ));
    }

    /**
     * Keep only rows whose `tipas` matches the given value.
     *
     * Accepts a raw int or any int-backed enum (ProductTypeId / ClientTypeId /
     * ServiceTypeId), so server-defined `tipas` values without an enum case
     * (e.g. product tipas 100) can still be selected. An unknown `tipas`
     * simply yields an empty collection — that is normal for tag groups the
     * server has not configured.
     */
    public function whereType(int|BackedEnum $tipas): self
    {
        $value = $tipas instanceof BackedEnum ? (int) $tipas->value : $tipas;

        return $this->filter(fn (TypeTag $row) => $row->tipas === $value);
    }

    /**
     * Group the whole dictionary by `tipas` in a single pass.
     *
     * @return array<int, TypeTagCollection>
     */
    public function groupByType(): array
    {
        return $this->groupBy(fn (TypeTag $row) => $row->tipas);
    }

    /**
     * The distinct `tipas` values present in this dictionary.
     *
     * @return array<int, int>
     */
    public function types(): array
    {
        return array_values(array_unique($this->map(fn (TypeTag $row) => $row->tipas)));
    }

    /**
     * Find the first row with the given code.
     */
    public function findByCode(string $code): ?TypeTag
    {
        foreach ($this->items as $row) {
            if ($row->code === $code) {
                return $row;
            }
        }

        return null;
    }
}
