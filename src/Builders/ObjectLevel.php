<?php

declare(strict_types=1);

namespace Finvalda\Builders;

use Finvalda\Exceptions\ValidationException;

/**
 * Field name of an analytical object level (sObjektas1..6). Finvalda has six
 * levels; any other number would build a field the server silently drops.
 *
 * @internal
 */
final class ObjectLevel
{
    /**
     * @throws ValidationException  On a level outside 1-6.
     */
    public static function key(int|string $level): string
    {
        if (! in_array($level, [1, 2, 3, 4, 5, 6], true)) {
            throw new ValidationException("Analytical object level must be 1-6, {$level} given");
        }

        return "sObjektas{$level}";
    }
}
