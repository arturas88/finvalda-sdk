<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Closure;
use Finvalda\Enums\OpClass;
use Finvalda\HttpClient;
use Finvalda\Query\OperationQuery;
use Finvalda\Resources\Operations;
use Finvalda\Resources\Pricing;
use Finvalda\Resources\Stock;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * PHP silently drops extra arguments. Where v4 removed parameters the server
 * never honoured, a v3 call would still run and the caller would believe it
 * filtered; these calls are refused before anything is sent.
 */
class DroppedArgumentsTest extends TestCase
{
    use CreatesMockHttpClient;

    /**
     * @return array<string, array{Closure(HttpClient): mixed, string}>
     */
    public static function calls(): array
    {
        return [
            'clientItemPrices with codes' => [fn ($h) => (new Pricing($h))->clientItemPrices('CLI001', 'PRD001'), 'clientItemPrices'],
            'balancesByGroup with dates' => [fn ($h) => (new Stock($h))->balancesByGroup('P', 'G', '2024-01-01'), 'balancesByGroup'],
            'query with a query object and filters' => [
                fn ($h) => (new Operations($h))->query(OperationQuery::sales()->journal('PARD'), ['filter' => ['Journal' => 'X']]),
                'OperationQuery',
            ],
        ];
    }

    #[DataProvider('calls')]
    public function test_a_v3_call_with_dropped_arguments_is_refused(Closure $call, string $named): void
    {
        $history = [];

        try {
            $call($this->createHttpClient([], $history));
            $this->fail('Expected InvalidArgumentException');
        } catch (InvalidArgumentException $e) {
            $this->assertStringContainsString($named, $e->getMessage());
        }

        $this->assertSame([], $history);
    }

    public function test_the_v4_calls_still_go_through(): void
    {
        $history = [];
        $http = $this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success']),
            $this->jsonResponse(['AccessResult' => 'Success']),
            $this->jsonResponse(['AccessResult' => 'Success']),
        ], $history);

        (new Pricing($http))->clientItemPrices();
        (new Stock($http))->balancesByGroup('P', 'G');
        (new Operations($http))->query(OpClass::Sales, ['filter' => ['Journal' => 'X']]);

        $this->assertCount(3, $history);
    }
}
