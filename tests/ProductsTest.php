<?php

declare(strict_types=1);

namespace Finvalda\Tests;

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
}
