<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\DescriptionType;
use Finvalda\Resources\Descriptions;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class DescriptionsTest extends TestCase
{
    use CreatesMockHttpClient;

    public function test_stock_on_date_nests_filter_under_type_key(): void
    {
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->stockOnDate('2024-01-15', ['Warehouse' => 'W01']);

        $this->assertSame([
            'readParams' => [
                'type' => 'StockOnDate',
                'StockOnDate' => ['Date' => '2024-01-15', 'Warehouse' => 'W01'],
            ],
        ], $this->decodeBody($history[0]['request']));
    }

    public function test_current_stock_nests_filter_under_products_key(): void
    {
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->currentStock(['Codes' => ['A', 'B']], 1, 50);

        $this->assertSame([
            'readParams' => [
                'type' => 'CurrentStock',
                'page' => 1,
                'limit' => 50,
                'Products' => ['Codes' => ['A', 'B']],
            ],
        ], $this->decodeBody($history[0]['request']));
    }

    public function test_bar_codes_nests_filter_under_products_key(): void
    {
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->barCodes(['BarCodes' => ['47700001']]);

        $this->assertSame([
            'readParams' => [
                'type' => 'BarCodes',
                'Products' => ['BarCodes' => ['47700001']],
            ],
        ], $this->decodeBody($history[0]['request']));
    }

    public function test_types_and_tags_uses_types_and_tags_wire_name(): void
    {
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->typesAndTags('client', 0);

        $this->assertSame([
            'readParams' => [
                'type' => 'TypesAndTags',
                'TypesAndTags' => ['Type' => 'client', 'Number' => 0],
            ],
        ], $this->decodeBody($history[0]['request']));
    }

    public function test_currency_rates_nests_filter_under_currency_rates_key(): void
    {
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->currencyRates('2024-01-01', '2024-01-31', ['USD', 'EUR']);

        $this->assertSame([
            'readParams' => [
                'type' => 'CurrencyRates',
                'CurrencyRates' => [
                    'DateFrom' => '2024-01-01',
                    'DateTo' => '2024-01-31',
                    'Codes' => ['USD', 'EUR'],
                ],
            ],
        ], $this->decodeBody($history[0]['request']));
    }

    public function test_document_series_nests_filter_under_series_key(): void
    {
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->documentSeries(0, 'ADMIN.');

        $this->assertSame([
            'readParams' => [
                'type' => 'DocumentSeries',
                'Series' => ['Type' => 0, 'UserName' => 'ADMIN.'],
            ],
        ], $this->decodeBody($history[0]['request']));
    }

    public function test_client_groups_sends_only_type_when_no_filter(): void
    {
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->clientGroups();

        $this->assertSame([
            'readParams' => ['type' => 'ClientGroups'],
        ], $this->decodeBody($history[0]['request']));
    }

    public function test_generic_get_passes_columns_at_top_level(): void
    {
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->get(
            DescriptionType::Products,
            ['Codes' => ['A']],
            page: 1,
            limit: 10,
            columns: ['product', 'title'],
        );

        $this->assertSame([
            'readParams' => [
                'type' => 'Products',
                'page' => 1,
                'limit' => 10,
                'Products' => ['Codes' => ['A']],
                'columns' => ['product', 'title'],
            ],
        ], $this->decodeBody($history[0]['request']));
    }

    public function test_extra_read_params_reach_the_wire_for_multi_key_filters(): void
    {
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->get(
            DescriptionType::Address,
            ['Codes' => ['TEST']],
            readParams: ['Address' => ['Codes' => ['SAN1']]],
        );

        $this->assertSame([
            'readParams' => [
                'type' => 'Address',
                'Clients' => ['Codes' => ['TEST']],
                'Address' => ['Codes' => ['SAN1']],
            ],
        ], $this->decodeBody($history[0]['request']));
    }

    public function test_addresses_sends_both_the_client_and_the_address_filter(): void
    {
        // FVS_Webservice §4.21: { type: "Address", Clients: {...}, Address: {...} }
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->addresses(
            clients: ['Codes' => ['TEST', 'TEST2']],
            addresses: ['Codes' => ['SAN1', 'SAN2'], 'Tag1' => 'X'],
            page: 1,
            limit: 10,
        );

        $this->assertSame([
            'readParams' => [
                'type' => 'Address',
                'page' => 1,
                'limit' => 10,
                'Clients' => ['Codes' => ['TEST', 'TEST2']],
                'Address' => ['Codes' => ['SAN1', 'SAN2'], 'Tag1' => 'X'],
            ],
        ], $this->decodeBody($history[0]['request']));
    }

    public function test_stock_on_date_and_currency_rates_accept_date_objects(): void
    {
        $history = [];
        $descriptions = new Descriptions($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $descriptions->stockOnDate(new \DateTimeImmutable('2024-01-15 10:00'));
        $descriptions->currencyRates(new \DateTimeImmutable('2024-01-01'), '2024-01-31');

        $this->assertSame(['Date' => '2024-01-15'], $this->decodeBody($history[0]['request'])['readParams']['StockOnDate']);
        $this->assertSame(
            ['DateFrom' => '2024-01-01', 'DateTo' => '2024-01-31'],
            $this->decodeBody($history[1]['request'])['readParams']['CurrencyRates'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function decodeBody(RequestInterface $request): array
    {
        return json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }
}
