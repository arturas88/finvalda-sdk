<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\ProductTypeId;
use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Exceptions\NotFoundException;
use Finvalda\Resources\Products;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\TestCase;

class ProductsTest extends TestCase
{
    use CreatesMockHttpClient;

    public function test_find_throws_not_found_when_entity_envelope_is_null(): void
    {
        $products = new Products($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Success',
                'error' => '',
                'Fvs.Preke' => null,
            ]),
        ]));

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage("Product '9534007890' not found");

        $products->find('9534007890');
    }

    public function test_find_unwraps_entity_envelope_into_populated_dto(): void
    {
        $products = new Products($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Success',
                'error' => '',
                'Fvs.Preke' => [
                    'sKodas' => 'PRE_01',
                    'sPavadinimas' => 'Pirma preke',
                    'dKaina1' => 20,
                    'sMatavimoVnt' => 'VNT',
                ],
            ]),
        ]));

        $product = $products->find('PRE_01');

        $this->assertSame('PRE_01', $product->code);
        $this->assertSame('Pirma preke', $product->name);
        $this->assertSame(20.0, $product->price1);
        $this->assertSame('VNT', $product->measureUnit);
    }

    public function test_find_still_parses_single_element_list_responses(): void
    {
        $products = new Products($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Success',
                'items' => [
                    ['sKodas' => 'PRE_01', 'sPavadinimas' => 'Pirma preke'],
                ],
            ]),
        ]));

        $product = $products->find('PRE_01');

        $this->assertSame('PRE_01', $product->code);
        $this->assertSame('Pirma preke', $product->name);
    }

    public function test_find_throws_not_found_when_response_failed(): void
    {
        $products = new Products($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Fail',
                'error' => 'some error',
            ]),
        ]));

        $this->expectException(NotFoundException::class);

        $products->find('PRE_01');
    }

    public function test_image_jpeg_returns_decoded_binary_contents(): void
    {
        $jpg = "\xFF\xD8\xFF\xE0\x00\x10JFIF image bytes";
        $products = new Products($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Success',
                'error' => '',
                'fileContents' => base64_encode($jpg),
            ]),
        ]));

        $this->assertSame($jpg, $products->imageJpeg('SKU-1'));
    }

    public function test_image_jpeg_sends_expected_query_params(): void
    {
        $history = [];
        $products = new Products($this->createHttpClient([
            $this->jsonResponse([
                'AccessResult' => 'Success',
                'fileContents' => base64_encode('jpg'),
            ]),
        ], $history));

        $products->imageJpeg('SKU-1', '2024-01-15');

        parse_str($history[0]['request']->getUri()->getQuery(), $query);
        $this->assertSame('GetPrekesImage', basename($history[0]['request']->getUri()->getPath()));
        $this->assertSame('SKU-1', $query['sPreKod']);
        $this->assertSame('2024-01-15', $query['tKoregavimoData']);
    }

    public function test_image_jpeg_throws_when_file_contents_missing(): void
    {
        $products = new Products($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success']),
        ]));

        $this->expectException(FinvaldaException::class);
        $this->expectExceptionMessage('GetPrekesImage did not contain fileContents');

        $products->imageJpeg('SKU-1');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function productTypeTagDataset(): array
    {
        return [
            ['tipas' => 0, 'kodas' => 'RUS1', 'pavadinimas' => 'Type one', 'info1' => 'a', 'info2' => 'b'],
            ['tipas' => 0, 'kodas' => 'RUS2', 'pavadinimas' => 'Type two'],
            ['tipas' => 1, 'kodas' => 'P1A', 'pavadinimas' => 'Tag1 value'],
            ['tipas' => 2, 'kodas' => 'P2A', 'pavadinimas' => 'Tag2 value'],
            ['tipas' => 100, 'kodas' => 'GAM', 'pavadinimas' => 'Apmokestinamieji gaminiai'],
        ];
    }

    public function test_types_and_tags_filters_full_dataset_by_tipas(): void
    {
        $products = new Products($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => $this->productTypeTagDataset()]),
        ]));

        $types = $products->typesAndTags(ProductTypeId::Type);

        $this->assertCount(2, $types);
        $this->assertSame(['RUS1', 'RUS2'], $types->pluck('code'));
        $this->assertSame(0, $types->first()->tipas);
        $this->assertSame('Type one', $types->first()->name);
        $this->assertSame('a', $types->first()->info1);
        $this->assertSame('b', $types->first()->info2);
    }

    public function test_types_and_tags_accepts_raw_int_for_tipas_without_enum_case(): void
    {
        $products = new Products($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => $this->productTypeTagDataset()]),
        ]));

        $rows = $products->typesAndTags(100);

        $this->assertCount(1, $rows);
        $this->assertSame('GAM', $rows->first()->code);
        $this->assertSame('Apmokestinamieji gaminiai', $rows->first()->name);
    }

    public function test_types_and_tags_returns_empty_collection_for_unconfigured_group(): void
    {
        $products = new Products($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => $this->productTypeTagDataset()]),
        ]));

        $this->assertTrue($products->typesAndTags(ProductTypeId::Tag5)->isEmpty());
    }

    public function test_all_types_and_tags_returns_whole_dictionary_grouped_by_tipas(): void
    {
        $products = new Products($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => $this->productTypeTagDataset()]),
        ]));

        $all = $products->allTypesAndTags();
        $this->assertCount(5, $all);

        $grouped = $all->groupByType();
        $this->assertSame([0, 1, 2, 100], array_keys($grouped));
        $this->assertCount(2, $grouped[0]);
        $this->assertCount(1, $grouped[100]);
    }

    public function test_types_and_tags_does_not_send_legacy_nid_and_is_cached(): void
    {
        $history = [];
        $products = new Products($this->createHttpClient([
            // Only ONE response queued: a second HTTP call would throw, proving the cache.
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => $this->productTypeTagDataset()]),
        ], $history));

        $products->allTypesAndTags();
        $products->typesAndTags(ProductTypeId::Tag1);
        $products->typesAndTags(100);

        $this->assertCount(1, $history);
        parse_str($history[0]['request']->getUri()->getQuery(), $query);
        $this->assertArrayNotHasKey('nID', $query);
        $this->assertSame('GetPrekiuRusisPozymius', basename($history[0]['request']->getUri()->getPath()));
    }
}
