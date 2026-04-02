<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Debt type filter values for client debt queries.
 */
enum DebtType: int
{
    case All = 0;
    case Receivable = 1;
    case Payable = 2;
}
