<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\DescriptionType;
use Finvalda\Resources\Descriptions;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\TestCase;

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

    /**
     * @return array<string, mixed>
     */
    private function decodeBody(\Psr\Http\Message\RequestInterface $request): array
    {
        return json_decode((string) $request->getBody(), true, flags: JSON_THROW_ON_ERROR);
    }
}
