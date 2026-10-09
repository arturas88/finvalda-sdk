<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Kind of document a clearing (UzskaitaDok) line settles — the line's nTipas.
 * Each side accepts its own subset; Account (6) is valid on both.
 *
 * The spec rows name "Išmoka" on the debit side and "Įplauka" on the credit
 * side but drop their numbers, so Inflow = 0 and Disbursement = 1 are inferred
 * (the only values left). Until a server confirms them, both are accepted on
 * either side; the numbered types (2-6) keep their documented side.
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

    /** UzskaitaDebitDetEil: disbursement, 3 sales, 4 purchase returns, 6 account (+ inflow, see above). */
    public function isDebit(): bool
    {
        return in_array($this, [self::Inflow, self::Disbursement, self::Sale, self::PurchaseReturn, self::Account], true);
    }

    /** UzskaitaKreditDetEil: inflow, 2 purchases, 5 sales returns, 6 account (+ disbursement, see above). */
    public function isCredit(): bool
    {
        return in_array($this, [self::Inflow, self::Disbursement, self::Purchase, self::SalesReturn, self::Account], true);
    }
}
