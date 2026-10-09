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

    /**
     * @param  array<int, array<string, mixed>>  $history
     */
    private function pricing(array &$history): Pricing
    {
        return new Pricing($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));
    }

    /**
     * @return array<string, string>
     */
    private function query(array $history): array
    {
        parse_str($history[0]['request']->getUri()->getQuery(), $query);

        return $query;
    }

    public function test_client_item_prices_sends_no_filters_because_the_endpoint_takes_none(): void
    {
        // GetKliPrekPasNuolPapKain(out DataSet Data, out string sError): it
        // returns every client's discounts; nothing narrows it server-side.
        $history = [];

        $this->pricing($history)->clientItemPrices();

        $this->assertSame('GetKliPrekPasNuolPapKain', basename($history[0]['request']->getUri()->getPath()));
        $this->assertSame([], $this->query($history));
    }

    public function test_the_combined_price_endpoints_take_only_date_filters(): void
    {
        foreach ([
            'clientTypeItemPrices' => 'GetKliRusPrekPasNuolPapKain',
            'clientItemTypePrices' => 'GetKliPrekPasRusNuolPapKain',
            'clientTypeItemTypePrices' => 'GetKliRusPrekPasRusNuolPapKain',
        ] as $method => $endpoint) {
            $history = [];

            $this->pricing($history)->{$method}(modifiedSince: '2024-01-01', createdSince: '2023-01-01');

            $this->assertSame($endpoint, basename($history[0]['request']->getUri()->getPath()));
            $this->assertSame(
                ['tKoregavimoData' => '2024-01-01', 'tSukurimoData' => '2023-01-01'],
                $this->query($history),
                $method,
            );
        }
    }
}
