<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

/**
 * Marked flag on the operation header (nPozymis: 1 marked, 0 not).
 *
 * Used only by builders whose operation header has nPozymis in the spec.
 */
trait SetsMarked
{
    public function marked(bool $marked = true): static
    {
        $this->header['nPozymis'] = $marked ? 1 : 0;

        return $this;
    }
}
