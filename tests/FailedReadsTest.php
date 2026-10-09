<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Exceptions\NotFoundException;
use Finvalda\HttpClient;
use Finvalda\Resources\Clients;
use Finvalda\Resources\Products;
use Finvalda\Resources\Services;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * A failed read must never look like "no rows" or "not found": a sync job
 * that deletes local clients missing from collect() would wipe them all.
 */
class FailedReadsTest extends TestCase
{
    use CreatesMockHttpClient;

    /**
     * @return array<string, array{class-string}>
     */
    public static function resources(): array
    {
        return [
            'clients' => [Clients::class],
            'products' => [Products::class],
            'services' => [Services::class],
        ];
    }

    private function failingClient(int $failures = 1): HttpClient
    {
        $responses = array_fill(0, $failures, $this->jsonResponse(['AccessResult' => 'Fail', 'error' => 'db offline']));

        return $this->createHttpClient($responses);
    }

    /**
     * @param  class-string<Clients|Products|Services>  $class
     */
    #[DataProvider('resources')]
    public function test_collect_throws_when_the_request_failed(string $class): void
    {
        $resource = new $class($this->failingClient());

        $this->expectException(FinvaldaException::class);
        $this->expectExceptionMessage('db offline');

        $resource->collect();
    }

    /**
     * @param  class-string<Clients|Products|Services>  $class
     */
    #[DataProvider('resources')]
    public function test_find_reports_a_failed_request_as_a_failure_not_as_not_found(string $class): void
    {
        $resource = new $class($this->failingClient());

        try {
            $resource->find('X');
            $this->fail('find() returned on a failed response');
        } catch (FinvaldaException $e) {
            $this->assertNotInstanceOf(NotFoundException::class, $e);
            $this->assertStringContainsString('db offline', $e->getMessage());
        }
    }

    /**
     * @param  class-string<Clients|Products|Services>  $class
     */
    #[DataProvider('resources')]
    public function test_types_and_tags_throws_and_does_not_cache_a_failure(string $class): void
    {
        $history = [];
        $resource = new $class($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Fail', 'error' => 'db offline']),
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => [
                ['tipas' => 0, 'kodas' => 'R1', 'pavadinimas' => 'Type'],
            ]]),
        ], $history));

        try {
            $resource->allTypesAndTags();
            $this->fail('allTypesAndTags() returned on a failed response');
        } catch (FinvaldaException $e) {
            $this->assertStringContainsString('db offline', $e->getMessage());
        }

        $this->assertSame(['R1'], $resource->allTypesAndTags()->pluck('code'));
        $this->assertCount(2, $history, 'the failure must not be served from the cache');
    }
}
