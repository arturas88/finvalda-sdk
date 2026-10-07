<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use DateTimeImmutable;
use Finvalda\Resources\OrderManagement;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class OrderManagementTest extends TestCase
{
    use CreatesMockHttpClient;

    /**
     * @return array<string, array{string, string}>
     */
    public static function reservationReads(): array
    {
        return [
            'completed' => ['completedReservations', 'GetUVMPardRIvykdyti'],
            'pending' => ['pendingReservations', 'GetUVMPardRNeivykdyti'],
            'cancelled' => ['cancelledReservations', 'GetUVMPardRAnuliuoti'],
            'ordered products' => ['orderedProducts', 'GetUVMPardRUzsakytosPrekes'],
        ];
    }

    #[DataProvider('reservationReads')]
    public function test_the_period_is_sent_as_t_nuo_and_t_iki(string $method, string $endpoint): void
    {
        // FVS_Webservice §3.60–3.62: GetUVMPardR*(string sZurnaluGrupe, DateTime tNuo,
        // DateTime tIki, DateTime tKoregavimoData, DateTime tSukurimoData, ...)
        $history = [];
        $resource = new OrderManagement($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $resource->{$method}(
            journalGroup: 'UVM',
            dateFrom: new DateTimeImmutable('2024-01-01 13:45'),
            dateTo: '2024-01-31',
            modifiedSince: new DateTimeImmutable('2023-12-01'),
            createdSince: '2023-11-01',
        );

        parse_str($history[0]['request']->getUri()->getQuery(), $query);

        $this->assertSame($endpoint, basename($history[0]['request']->getUri()->getPath()));
        $this->assertSame([
            'sZurnaluGrupe' => 'UVM',
            'tNuo' => '2024-01-01',
            'tIki' => '2024-01-31',
            'tKoregavimoData' => '2023-12-01',
            'tSukurimoData' => '2023-11-01',
        ], $query);
    }

    public function test_reservation_status_identifies_the_operation(): void
    {
        $history = [];
        $resource = new OrderManagement($this->createHttpClient([
            $this->jsonResponse(['AccessResult' => 'Success', 'items' => []]),
        ], $history));

        $resource->salesReservationStatus('UVM', 7);

        parse_str($history[0]['request']->getUri()->getQuery(), $query);

        $this->assertSame('GetUVMPardRBusena', basename($history[0]['request']->getUri()->getPath()));
        $this->assertSame(['sZurnalas' => 'UVM', 'nNumeris' => '7'], $query);
    }
}
