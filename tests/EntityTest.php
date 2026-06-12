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
}
