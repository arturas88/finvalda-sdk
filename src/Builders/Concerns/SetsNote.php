<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

/**
 * Operation note (sPastaba).
 *
 * Used only by builders whose operation header has sPastaba in the spec.
 */
trait SetsNote
{
    public function note(string $note): static
    {
        $this->header['sPastaba'] = $note;

        return $this;
    }
}
