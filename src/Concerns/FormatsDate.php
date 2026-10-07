<?php

declare(strict_types=1);

namespace Finvalda\Concerns;

use DateTimeInterface;
use InvalidArgumentException;

trait FormatsDate
{
    /**
     * Format a date parameter for the API.
     *
     * DateTimeInterface objects are formatted as Y-m-d. Strings must already be
     * Y-m-d, optionally followed by a time of day (`2024-01-15T10:30:00` or
     * `2024-01-15 10:30`); they are passed through unchanged. Anything else is
     * refused rather than sent, since the server's reaction to "15/01/2024" is
     * not something to find out in production.
     *
     * @throws InvalidArgumentException  On a string that is not a valid Y-m-d date.
     */
    protected function formatDate(DateTimeInterface|string|null $date): ?string
    {
        if ($date instanceof DateTimeInterface) {
            return $date->format('Y-m-d');
        }

        if ($date === null) {
            return null;
        }

        if (! preg_match('/^(\d{4})-(\d{2})-(\d{2})(?:[T ]\d{2}:\d{2}(?::\d{2}(?:\.\d+)?)?)?$/', $date, $m)
            || ! checkdate((int) $m[2], (int) $m[3], (int) $m[1])
        ) {
            throw new InvalidArgumentException("Expected a Y-m-d date, got '{$date}'");
        }

        return $date;
    }
}
