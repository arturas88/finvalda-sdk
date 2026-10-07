<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * How an inflow/disbursement (IplDok/IsmDok) settles documents — the
 * required nTipas header field.
 */
enum PaymentType: int
{
    /** Advance payment (avansinis mokėjimas). */
    case Advance = 0;

    /** Settles the client's open documents oldest-first (FIFO). */
    case Fifo = 1;

    /** Settles the documents named on the detail lines (sSerija/sDokumentas). */
    case Documents = 3;
}
