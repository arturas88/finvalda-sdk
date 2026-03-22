<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Entity types for AttachDocument.
 */
enum DocumentEntityType: int
{
    case Account = 1;
    case Client = 2;
    case Sale = 3;
    case Purchase = 7;
    case Product = 8;
    case Service = 16;
    case SalesReturn = 74;
    case SalesReservation = 75;
    case PurchaseReturn = 76;
    case PurchaseOrder = 77;
    case InternalTransfer = 78;
    case WriteOff = 97;
    case Capitalization = 98;
}
