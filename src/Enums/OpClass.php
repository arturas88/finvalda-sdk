<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Operation classes for GetOperations.
 */
enum OpClass: string
{
    case Sales = 'Sales';
    case SalesDet = 'SalesDet';
    case SalesReturns = 'SalesReturns';
    case SalesReturnsDet = 'SalesReturnsDet';
    case Purchases = 'Purchases';
    case PurchasesDet = 'PurchasesDet';
    case PurchasesReturns = 'PurchasesReturns';
    case PurchasesReturnsDet = 'PurchasesReturnsDet';
    case Capitalization = 'Capitalization';
    case CapitalizationDet = 'CapitalizationDet';
    case WriteOff = 'WriteOff';
    case WriteOffDet = 'WriteOffDet';
    case Inflows = 'Inflows';
    case InflowsDet = 'InflowsDet';
    case Disbursement = 'Disbursement';
    case DisbursementDet = 'DisbursementDet';
    case ClearingOff = 'ClearingOff';
    case ClearingOffDet = 'ClearingOffDet';
    case SalesReservations = 'SalesReservations';
    case SalesReservationsDet = 'SalesReservationsDet';
    case PurchaseOrders = 'PurchaseOrders';
    case PurchaseOrdersDet = 'PurchaseOrdersDet';
    case InternalTransactions = 'InternalTransactions';
    case InternalTransactionsDet = 'InternalTransactionsDet';
    case GeneralLedger = 'GenLeadger'; // API uses "Leadger" (sic)
    case GeneralLedgerDet = 'GenLeadgerDet'; // API uses "Leadger" (sic)
}
