<?php

declare(strict_types=1);

namespace Finvalda\Enums;

enum UpdateOperationClass: string
{
    case Sale = 'KoregPardDok';
    case SalesReservation = 'KoregPardRezDok';
    case SalesReturn = 'KoregPardGrazDok';
    case Purchase = 'KoregPirkDok';
    case PurchaseOrder = 'KoregPirkUzsDok';
    case PurchaseReturn = 'KoregPirkGrazDok';
    case InternalTransfer = 'KoregVidPerkDok';
}
