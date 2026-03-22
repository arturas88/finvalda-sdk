<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Operation class names for InsertNewOperation.
 */
enum OperationClass: string
{
    // Sales
    case Sale = 'PardDok';
    case SaleShort = 'TrumpasPardDok';
    case SalesReservation = 'PardRezDok';
    case SalesReservationShort = 'TrumpasPardRezDok';
    case SalesReturn = 'PardGrazDok';
    case SalesReturnShort = 'TrumpasPardGrazDok';

    // Purchases
    case Purchase = 'PirkDok';
    case PurchaseShort = 'TrumpasPirkDok';
    case PurchaseOrder = 'PirkUzsDok';
    case PurchaseOrderShort = 'TrumpasPirkUzsDok';
    case PurchaseReturn = 'PirkGrazDok';
    case PurchaseReturnShort = 'TrumpasPirkGrazDok';

    // Transfers & Adjustments
    case InternalTransfer = 'VidPerkDok';
    case WriteOff = 'NurasymasDok';
    case Capitalization = 'PajamavimasDok';
    case InventoryCount = 'Inventorizacija';

    // Payments
    case Inflow = 'IplDok';
    case Disbursement = 'IsmokasDok';
    case Clearing = 'UzskaitaDok';

    // Production
    case Production = 'GamybaDok';

    // Other
    case NonAnalytical = 'KtNeanalitDok';

    // UVM (Order Management)
    case UvmSalesReservation = 'UVMPardRezDok';
    case UvmCancellation = 'UVMAnulDok';
    case UvmPurchaseOrder = 'UVMPirkUzsDok';
}
