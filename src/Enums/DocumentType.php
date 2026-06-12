<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Document type codes (sDokRusis) for sales and purchase operations.
 *
 * Set on the operation header to mark which kind of document the operation
 * represents. Independent of sParametras (which selects the server-configured
 * journal/import profile) and of sSerija (the document series).
 */
enum DocumentType: string
{
    case Invoice = 'S';                 // Sąskaita faktūra
    case VatInvoice = 'SF';             // PVM sąskaita faktūra
    case DebitInvoice = 'D';            // Debetinė sąskaita
    case DebitVatInvoice = 'DS';        // Debetinė PVM sąskaita
    case CreditInvoice = 'K';           // Kreditinė sąskaita
    case CreditVatInvoice = 'KS';       // Kreditinė PVM sąskaita faktūra
    case Other = 'KT';                  // Kita
    case LawyerVatInvoice = 'VS';       // Advokatų PVM sąskaita faktūra
    case LawyerVatInvoiceDebit = 'VD';  // Advokatų PVM sąskaita faktūra debetinė
    case LawyerVatInvoiceCredit = 'VK'; // Advokatų PVM sąskaita faktūra kreditinė

    /**
     * Lithuanian label as used in Finvalda.
     */
    public function label(): string
    {
        return match ($this) {
            self::Invoice => 'Sąskaita faktūra',
            self::VatInvoice => 'PVM sąskaita faktūra',
            self::DebitInvoice => 'Debetinė sąskaita',
            self::DebitVatInvoice => 'Debetinė PVM sąskaita',
            self::CreditInvoice => 'Kreditinė sąskaita',
            self::CreditVatInvoice => 'Kreditinė PVM sąskaita faktūra',
            self::Other => 'Kita',
            self::LawyerVatInvoice => 'Advokatų PVM sąskaita faktūra',
            self::LawyerVatInvoiceDebit => 'Advokatų PVM sąskaita faktūra debetinė',
            self::LawyerVatInvoiceCredit => 'Advokatų PVM sąskaita faktūra kreditinė',
        };
    }
}
