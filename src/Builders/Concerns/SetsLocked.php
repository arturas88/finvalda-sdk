<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

/**
 * Locked flag (nVarna: 1 locked; the server default is unlocked).
 *
 * Used only by builders whose operation header has nVarna in the spec.
 */
trait SetsLocked
{
    public function locked(bool $locked = true): static
    {
        $this->header['nVarna'] = $locked ? 1 : 0;

        return $this;
    }
}
