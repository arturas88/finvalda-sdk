<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Resources\Products;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\TestCase;

class ProductsTest extends TestCase
{
    use CreatesMockHttpClient;

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
