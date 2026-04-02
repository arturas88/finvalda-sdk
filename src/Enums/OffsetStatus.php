<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Offset status for advance payment queries.
 */
enum OffsetStatus: int
{
    case NotOffset = 0;
    case Offset = 1;
    case All = 2;
}
