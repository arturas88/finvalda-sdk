<?php

declare(strict_types=1);

namespace Finvalda\Builders\Concerns;

/**
 * Client code (sKlientas).
 *
 * Used only by builders whose operation header has sKlientas in the spec.
 */
trait SetsClient
{
    public function client(string $clientCode): static
    {
        $this->header['sKlientas'] = $clientCode;

        return $this;
    }
}
