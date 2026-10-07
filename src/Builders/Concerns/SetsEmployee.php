<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

/**
 * Finvalda employee name (sDarbuotojas).
 *
 * Used only by builders whose operation header has sDarbuotojas in the spec.
 */
trait SetsEmployee
{
    public function employee(string $employee): static
    {
        $this->header['sDarbuotojas'] = $employee;

        return $this;
    }
}
