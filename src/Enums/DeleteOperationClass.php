<?php

declare(strict_types=1);

namespace Finvalda\Enums;

enum DeleteOperationClass: string
{
    case Purchase = 'DelPirkDok';
    case PurchaseOrder = 'DelPirkUzsDok';
    case PurchaseReturn = 'DelPirkGrazDok';
    case Sale = 'DelPardDok';
    case SalesReservation = 'DelPardRezDok';
    case SalesReturn = 'DelPardGrazDok';
    case InternalTransfer = 'DelVidPerkDok';
    case Inflow = 'DelIplDok';
    case UvmPurchaseOrder = 'DelUVMPirkUzsDok';
    case Production = 'DelGamybaDok';
}
