<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

/**
 * SetsEmployee for the builders whose v3 parameter was named $name, so
 * employee(name: ...) calls keep working. Same field, sDarbuotojas.
 */
trait SetsEmployeeByName
{
    public function employee(string $name): static
    {
        $this->header['sDarbuotojas'] = $name;

        return $this;
    }
}
