<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Kind of document a clearing (UzskaitaDok) line settles — the line's nTipas.
 * Each side accepts its own subset; Account (6) is valid on both.
 */
enum ClearingDocumentType: int
{
    case Inflow = 0;
    case Disbursement = 1;
    case Purchase = 2;
    case Sale = 3;
    case PurchaseReturn = 4;
    case SalesReturn = 5;
    case Account = 6;

    /** UzskaitaDebitDetEil: 1 disbursement, 3 sales, 4 purchase returns, 6 account. */
    public function isDebit(): bool
    {
        return in_array($this, [self::Disbursement, self::Sale, self::PurchaseReturn, self::Account], true);
    }

    /** UzskaitaKreditDetEil: 0 inflow, 2 purchases, 5 sales returns, 6 account. */
    public function isCredit(): bool
    {
        return in_array($this, [self::Inflow, self::Purchase, self::SalesReturn, self::Account], true);
    }
}
