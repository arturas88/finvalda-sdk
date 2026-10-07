<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Closure;
use Finvalda\Exceptions\OperationNotSupportedException;
use Finvalda\HttpClient;
use Finvalda\Resources\Clients;
use Finvalda\Resources\Objects;
use Finvalda\Resources\Products;
use Finvalda\Resources\References;
use Finvalda\Resources\Services;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * The InsertNewItem / EditItem / DeleteItem behaviour every description
 * resource shares.
 */
class ItemCrudTest extends TestCase
{
    use CreatesMockHttpClient;

    /**
     * @return array<string, array{Closure(HttpClient): mixed}>
     */
    public static function updatesWithoutCode(): array
    {
        return [
            'clients' => [fn ($h) => (new Clients($h))->update(['sPavadinimas' => 'N'])],
            'products' => [fn ($h) => (new Products($h))->update(['sPavadinimas' => 'N'])],
            'services' => [fn ($h) => (new Services($h))->update(['sKodas' => ''])],
            'objects' => [fn ($h) => (new Objects($h))->update(2, ['sPavadinimas' => 'N'])],
            'warehouse' => [fn ($h) => (new References($h))->updateWarehouse(['sPavadinimas' => 'N'])],
            'payment term' => [fn ($h) => (new References($h))->updatePaymentTerm([])],
            'product type' => [fn ($h) => (new References($h))->updateProductType([])],
        ];
    }

    /**
     * @param  Closure(HttpClient): mixed  $update
     */
    #[DataProvider('updatesWithoutCode')]
    public function test_an_update_without_a_code_is_refused_before_it_is_sent(Closure $update): void
    {
        // EditItem identifies the record by sItemCode; an empty one would
        // reach the server as a request to edit nothing in particular.
        $history = [];

        try {
            $update($this->createHttpClient([], $history));
            $this->fail('Expected InvalidArgumentException');
        } catch (InvalidArgumentException $e) {
            $this->assertStringContainsString('sKodas', $e->getMessage());
        }

        $this->assertSame([], $history);
    }

    /**
     * @return array<string, array{Closure(HttpClient): mixed}>
     */
    public static function deletes(): array
    {
        return [
            'clients' => [fn ($h) => (new Clients($h))->delete('K1')],
            'products' => [fn ($h) => (new Products($h))->delete('P1')],
            'services' => [fn ($h) => (new Services($h))->delete('S1')],
            'product type' => [fn ($h) => (new References($h))->deleteProductType('T1')],
        ];
    }

    /**
     * @param  Closure(HttpClient): mixed  $delete
     */
    #[DataProvider('deletes')]
    public function test_a_server_without_delete_item_raises_operation_not_supported(Closure $delete): void
    {
        $this->expectException(OperationNotSupportedException::class);

        $delete($this->createHttpClient([
            new GuzzleResponse(404, ['Content-Type' => 'text/html'], '<html><body>Endpoint not found.</body></html>'),
        ]));
    }
}
