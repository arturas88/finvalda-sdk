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
    // The spec documents the IsmDok envelope (shared table "IplDok, IsmDok")
    // but leaves it out of the InsertNewOperation ItemClassName list.
    case Disbursement = 'IsmDok';
    case Clearing = 'UzskaitaDok';

    // Production
    case Production = 'GamybaDok';

    // Other
    case NonAnalytical = 'KtNeanalitDok';

    // UVM (Order Management)
    case UvmSalesReservation = 'UVMPardRezDok';
    case UvmSalesReservationShort = 'TrumpasUVMPardRezDok';
    case UvmCancellation = 'UVMAnulDok';
    case UvmPurchaseOrder = 'UVMPirkUzsDok';
    case UvmPurchaseOrderShort = 'TrumpasUVMPirkUzsDok';

    /**
     * The DeleteOperation class that removes an operation of this class, or
     * null when the spec offers none (write-offs, capitalizations, inventory
     * counts, disbursements, clearings, non-analytical, UVM reservations and
     * cancellations). Short variants delete as their full class.
     */
    public function deleteClass(): ?DeleteOperationClass
    {
        return match ($this) {
            self::Sale, self::SaleShort => DeleteOperationClass::Sale,
            self::SalesReservation, self::SalesReservationShort => DeleteOperationClass::SalesReservation,
            self::SalesReturn, self::SalesReturnShort => DeleteOperationClass::SalesReturn,
            self::Purchase, self::PurchaseShort => DeleteOperationClass::Purchase,
            self::PurchaseOrder, self::PurchaseOrderShort => DeleteOperationClass::PurchaseOrder,
            self::PurchaseReturn, self::PurchaseReturnShort => DeleteOperationClass::PurchaseReturn,
            self::InternalTransfer => DeleteOperationClass::InternalTransfer,
            self::Inflow => DeleteOperationClass::Inflow,
            self::UvmPurchaseOrder, self::UvmPurchaseOrderShort => DeleteOperationClass::UvmPurchaseOrder,
            self::Production => DeleteOperationClass::Production,
            default => null,
        };
    }
}
