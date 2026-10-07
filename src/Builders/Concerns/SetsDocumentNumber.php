<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

/**
 * Operation document number (sDokumentas).
 *
 * Used only by builders whose operation header has sDokumentas in the spec.
 */
trait SetsDocumentNumber
{
    public function documentNumber(string $number): static
    {
        $this->header['sDokumentas'] = $number;

        return $this;
    }
}
