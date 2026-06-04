<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Data\Product;
use LogicException;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
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
