<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Collections\ClientCollection;
use Finvalda\Collections\ProductCollection;
use Finvalda\Collections\ServiceCollection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    public function test_from_array_skips_malformed_rows(): void
    {
        // API responses occasionally carry scalar/null rows alongside records;
        // these used to produce a raw TypeError from the array-typed closure.
        $products = ProductCollection::fromArray([
            ['sKodas' => 'A'],
            null,
            'garbage',
            ['sKodas' => 'B'],
        ]);

        $this->assertCount(2, $products);
        $this->assertSame('A', $products->first()->code);
        $this->assertSame('B', $products->last()->code);

        $this->assertCount(1, ClientCollection::fromArray([['sKodas' => 'C'], 42]));
        $this->assertCount(1, ServiceCollection::fromArray([['sKodas' => 'S'], false]));
    }
}
