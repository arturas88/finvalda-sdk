<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

/**
 * A default warehouse for the operation's product lines.
 *
 * Sales, purchase, write-off and capitalization headers have no warehouse field;
 * the spec puts sSandelis on each product line (required on sales and purchase
 * lines). warehouse() therefore never touches the header: build() copies it into
 * every product line that does not name its own.
 */
trait HasDefaultWarehouse
{
    private ?string $defaultWarehouse = null;

    /**
     * Warehouse for every product line that does not set its own sSandelis.
     */
    public function warehouse(string $warehouseCode): static
    {
        $this->defaultWarehouse = $warehouseCode;

        return $this;
    }

    /**
     * @param  array<int, array<string, mixed>>  $lines
     * @return array<int, array<string, mixed>>
     */
    protected function withDefaultWarehouse(array $lines): array
    {
        if ($this->defaultWarehouse === null) {
            return $lines;
        }

        return array_map(
            fn (array $line): array => $line + ['sSandelis' => $this->defaultWarehouse],
            $lines,
        );
    }
}
