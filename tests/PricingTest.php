<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Resources\Pricing;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\TestCase;

class PricingTest extends TestCase
{
    use CreatesMockHttpClient;

    public function test_recommended_price_wraps_params_in_inParams_envelope(): void
    {
        $history = [];
        $pricing = new Pricing($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $pricing->recommendedPrice([
            'invoiceType' => 0,
            'itemCode' => '101',
            'itemAmount' => 1,
            'clientCode' => '141577615',
        ]);

        $body = json_decode((string) $history[0]['request']->getBody(), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame([
            'inParams' => [
                'invoiceType' => 0,
                'itemCode' => '101',
                'itemAmount' => 1,
                'clientCode' => '141577615',
            ],
        ], $body);
    }
}
