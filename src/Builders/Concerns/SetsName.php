<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

/**
 * Operation name (sPavadinimas).
 *
 * Used only by builders whose operation header has sPavadinimas in the spec.
 */
trait SetsName
{
    public function name(string $name): static
    {
        $this->header['sPavadinimas'] = $name;

        return $this;
    }
}
