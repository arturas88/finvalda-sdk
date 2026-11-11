<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Enums\OperationClass;
use Finvalda\Finvalda;
use Finvalda\FinvaldaConfig;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Pins the wire shape of the payment builders to the FVS reference ("IplDok, IsmDok", "IplDokDetEil, IsmDokDetEil"):
 * class names, required nTipas, rows with dSumaV + sSerija + sDokumentas, rows inside the wrapper.
 * A live server refuses IsmokasDok ("Wrong ItemClassName") and accepts IplDok with exactly these rows.
 */
class PaymentBuilderTest extends TestCase
{
    use CreatesMockHttpClient;

    /** @return iterable<string, array{string, string}> */
    public static function payments(): iterable
    {
        yield 'inflow' => ['inflow', 'IplDok'];
        yield 'disbursement' => ['disbursement', 'IsmDok'];
    }

    private function finvalda(array &$history): Finvalda
    {
        $http = $this->createHttpClient([$this->jsonResponse(['AccessResult' => 'Success', 'nResult' => 0])], $history);

        return new Finvalda(new FinvaldaConfig(baseUrl: 'https://example.com', username: 'user', password: 'pass'), $http);
    }

    public function test_disbursement_class_is_ismdok(): void
    {
        $this->assertSame('IsmDok', OperationClass::Disbursement->value);
        $this->assertSame('IplDok', OperationClass::Inflow->value);
    }

    #[DataProvider('payments')]
    public function test_settle_sends_spec_rows_inside_the_wrapper(string $accessor, string $class): void
    {
        $history = [];
        $this->finvalda($history)->{$accessor}()
            ->client('CLI001')
            ->date('2026-11-09')
            ->currency('EUR')
            ->name('Payment')
            ->note('bank ref 2026110402784800-1')
            ->settle('HTL6', '147016', 500.00, 'Apmokėjimas')
            ->settle('HTL5', '029430', 20.50)
            ->save('BANK_9910');

        $body = json_decode((string) $history[0]['request']->getBody(), true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame($class, $body['ItemClassName']);
        $this->assertSame('BANK_9910', $body['sParametras']);
        $operation = json_decode($body['xmlstring'], true, flags: JSON_THROW_ON_ERROR);
        $this->assertSame([$class], array_keys($operation)); // the rows are inside, not a sibling of the wrapper
        $p = $operation[$class];
        $this->assertSame(3, $p['nTipas']);
        $this->assertSame('CLI001', $p['sKlientas']);
        $this->assertSame('2026-11-09', $p['tData']);
        $this->assertSame('Payment', $p['sPavadinimas']);
        $this->assertSame('bank ref 2026110402784800-1', $p['sPastaba']);
        $this->assertSame([
            ['sPavadinimas' => 'Apmokėjimas', 'dSumaV' => 500, 'sSerija' => 'HTL6', 'sDokumentas' => '147016'],
            ['dSumaV' => 20.5, 'sSerija' => 'HTL5', 'sDokumentas' => '029430'],
        ], $p[$class . 'DetEil']);
    }

    #[DataProvider('payments')]
    public function test_advance_and_fifo_keep_their_type(string $accessor, string $class): void
    {
        $history = [];
        $advance = $this->finvalda($history)->{$accessor}()->client('CLI001')->date('2026-11-09')->advance()->line(75.00, 'Avansas')->build();
        $this->assertSame(0, $advance[$class]['nTipas']);
        $this->assertSame([['sPavadinimas' => 'Avansas', 'dSumaV' => 75.0]], $advance[$class][$class . 'DetEil']);

        $fifo = $this->finvalda($history)->{$accessor}()->client('CLI001')->settleFifo()->settle('HTL5', '1', 1.0)->build();
        $this->assertSame(1, $fifo[$class]['nTipas']); // settle() does not override a type chosen before
    }

    #[DataProvider('payments')]
    public function test_product_rows_are_refused(string $accessor): void
    {
        $history = [];
        $this->expectException(\BadMethodCallException::class);
        $this->finvalda($history)->{$accessor}()->client('CLI001')->addProduct('PRD001', quantity: 1, price: 1.0)->build();
    }
}
