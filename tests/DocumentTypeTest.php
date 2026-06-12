<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\DocumentType;
use PHPUnit\Framework\TestCase;

class DocumentTypeTest extends TestCase
{
    public function test_codes_match_the_api_values(): void
    {
        $this->assertSame('S', DocumentType::Invoice->value);
        $this->assertSame('SF', DocumentType::VatInvoice->value);
        $this->assertSame('D', DocumentType::DebitInvoice->value);
        $this->assertSame('DS', DocumentType::DebitVatInvoice->value);
        $this->assertSame('K', DocumentType::CreditInvoice->value);
        $this->assertSame('KS', DocumentType::CreditVatInvoice->value);
        $this->assertSame('KT', DocumentType::Other->value);
        $this->assertSame('VS', DocumentType::LawyerVatInvoice->value);
        $this->assertSame('VD', DocumentType::LawyerVatInvoiceDebit->value);
        $this->assertSame('VK', DocumentType::LawyerVatInvoiceCredit->value);
    }

    public function test_all_codes_are_at_most_two_chars(): void
    {
        foreach (DocumentType::cases() as $case) {
            $this->assertLessThanOrEqual(2, strlen($case->value), "{$case->name} exceeds 2 chars");
        }
    }

    public function test_every_case_has_a_label(): void
    {
        foreach (DocumentType::cases() as $case) {
            $this->assertNotSame('', $case->label());
        }
    }
}
