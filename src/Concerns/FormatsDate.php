<?php

declare(strict_types=1);

namespace Finvalda\Concerns;

use DateTimeInterface;

trait FormatsDate
{
    /**
     * Format a date parameter for the API.
     * Accepts DateTimeInterface objects or date strings in Y-m-d format.
     */
    protected function formatDate(DateTimeInterface|string|null $date): ?string
    {
        if ($date instanceof DateTimeInterface) {
            return $date->format('Y-m-d');
        }

        return $date;
    }
}
