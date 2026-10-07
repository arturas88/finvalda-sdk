<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

/**
 * Operation currency (sValiuta).
 *
 * Used only by builders whose operation header has sValiuta in the spec.
 */
trait SetsCurrency
{
    public function currency(string $currency): static
    {
        $this->header['sValiuta'] = $currency;

        return $this;
    }
}
