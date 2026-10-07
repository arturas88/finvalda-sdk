<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Data\Client;
use Finvalda\Data\Product;
use LogicException;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function test_client_country_code_and_name_do_not_collide(): void
    {
        // Payload has only the country name (sValstybe), no separate code key.
        $client = Client::fromArray([
            'sKodas' => 'CLI001',
            'sPavadinimas' => 'Acme',
            'sValstybe' => 'Lietuva',
        ]);

        // The name must not leak into the code field.
        $this->assertNull($client->country);
        $this->assertSame('Lietuva', $client->countryName);
    }

    public function test_client_country_code_uses_code_key(): void
    {
        $client = Client::fromArray([
            'sKodas' => 'CLI001',
            'sPavadinimas' => 'Acme',
            'sValstybeKodas' => 'LT',
            'sValstybe' => 'Lietuva',
        ]);

        $this->assertSame('LT', $client->country);
        $this->assertSame('Lietuva', $client->countryName);
    }

    public function test_offset_get_reads_raw_data(): void
    {
        $product = Product::fromArray(['sKodas' => 'PRD001', 'sCustomField' => 'x']);

        $this->assertSame('x', $product['sCustomField']);
        $this->assertNull($product['missing']);
    }

    public function test_offset_set_throws_instead_of_silently_ignoring(): void
    {
        $product = Product::fromArray(['sKodas' => 'PRD001']);

        $this->expectException(LogicException::class);

        $product['sKodas'] = 'OTHER';
    }

    public function test_offset_unset_throws_instead_of_silently_ignoring(): void
    {
        $product = Product::fromArray(['sKodas' => 'PRD001']);

        $this->expectException(LogicException::class);

        unset($product['sKodas']);
    }

    public function test_a_numeric_value_in_a_string_column_is_kept_as_a_string(): void
    {
        // im_kodas is Char(13), but a company code is all digits: JSON may
        // carry it as a number, which a ?string property rejects outright.
        $client = Client::fromArray(['kodas' => 1001, 'pavadinimas' => 'Acme', 'im_kodas' => 302589123]);

        $this->assertSame('1001', $client->code);
        $this->assertSame('302589123', $client->companyCode);
    }

    public function test_an_empty_xml_element_is_null_not_an_array(): void
    {
        // XML responses decode <miestas/> to [] — not a string.
        $client = Client::fromArray(['sKodas' => 'K1', 'sPavadinimas' => 'Acme', 'miestas' => []]);

        $this->assertNull($client->city);
    }

    public function test_numbers_arriving_as_strings_are_parsed_and_junk_is_null(): void
    {
        $product = Product::fromArray(['sKodas' => 'P1', 'dKaina1' => '12.50', 'dKaina2' => 'n/a', 'nVietuSkaicius' => '3']);

        $this->assertSame(12.5, $product->price1);
        $this->assertNull($product->price2);
        $this->assertSame(3, $product->places);
    }

    /**
     * @return array<string, array{mixed, ?bool}>
     */
    public static function flags(): array
    {
        return [
            'int 1' => [1, true],
            'int 0' => [0, false],
            'string 0' => ['0', false],
            'string 1' => ['1', true],
            'N' => ['N', false],
            'T' => ['T', true],
            'false' => ['false', false],
            'true' => [true, true],
            'empty' => ['', false],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('flags')]
    public function test_flags_read_the_spellings_finvalda_uses(mixed $raw, ?bool $expected): void
    {
        $client = Client::fromArray(['sKodas' => 'K1', 'sPavadinimas' => 'Acme', 'nAktyvus' => $raw]);

        $this->assertSame($expected, $client->active);
    }

    public function test_has_subsidiary_reads_the_parent_code_column(): void
    {
        // yra_padalinys is Char(15): the code of the client this one is a
        // subsidiary of, so any code means true and an empty one false.
        $this->assertTrue(Client::fromArray(['kodas' => 'K1', 'yra_padalinys' => 'PARENT'])->hasSubsidiary);
        $this->assertFalse(Client::fromArray(['kodas' => 'K1', 'yra_padalinys' => ''])->hasSubsidiary);
    }
}
