<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use BadMethodCallException;
use Closure;
use Finvalda\Builders\CapitalizationBuilder;
use Finvalda\Builders\ClearingBuilder;
use Finvalda\Builders\InflowBuilder;
use Finvalda\Builders\InternalTransferBuilder;
use Finvalda\Builders\InventoryCountBuilder;
use Finvalda\Builders\ProductionBuilder;
use Finvalda\Builders\PurchaseBuilder;
use Finvalda\Builders\SaleBuilder;
use Finvalda\Builders\UvmCancellationBuilder;
use Finvalda\Builders\UvmSalesReservationBuilder;
use Finvalda\Builders\WriteOffBuilder;
use Finvalda\Enums\DocumentEntityType;
use Finvalda\HttpClient;
use Finvalda\Resources\Documents;
use Finvalda\Resources\Permissions;
use Finvalda\Tests\Concerns\CreatesMockHttpClient;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Methods whose v3 arguments meant something else are retired rather than
 * reused: an old positional call would otherwise still type-check and send
 * its values to the wrong fields. Each must fail loudly, name its
 * replacement, and send nothing.
 */
class RetiredMethodsTest extends TestCase
{
    use CreatesMockHttpClient;

    /**
     * @return array<string, array{Closure(HttpClient): mixed, string}>
     */
    public static function retired(): array
    {
        return [
            'forDocument' => [fn () => (new InflowBuilder())->forDocument('SF-123', 'PARD', 42, 500.0), 'payDocument('],
            'Documents::attach' => [fn ($h) => (new Documents($h))->attach(DocumentEntityType::Sale, '', 'a.pdf', 'PARD', 42), 'attachTo('],
            'Documents::attached' => [fn ($h) => (new Documents($h))->attached(DocumentEntityType::Sale, '', 'PARD', 42), 'attachedTo('],
            'Permissions::get' => [fn ($h) => (new Permissions($h))->get(65), 'forUser('],
        ];
    }

    #[DataProvider('retired')]
    public function test_a_retired_method_names_its_replacement_and_sends_nothing(Closure $call, string $replacement): void
    {
        $history = [];

        try {
            $call($this->createHttpClient([], $history));
            $this->fail('Expected LogicException');
        } catch (LogicException $e) {
            $this->assertStringContainsString('removed in v4', $e->getMessage());
            $this->assertStringContainsString($replacement, $e->getMessage());
        }

        $this->assertSame([], $history);
    }

    /**
     * @return array<string, array{object, string, string}>
     */
    public static function removedBuilderMethods(): array
    {
        return [
            'supplierInvoice' => [new PurchaseBuilder(), 'supplierInvoice', 'sTiekejoSF'],
            'paymentDays' => [new SaleBuilder(), 'paymentDays', 'nAtsiskDien'],
            'operationType' => [new UvmSalesReservationBuilder(), 'operationType', 'sOpTipas'],
            'responsiblePerson' => [new SaleBuilder(), 'responsiblePerson', 'sAtsakingasAsmuo'],
            'currency on a write-off' => [new WriteOffBuilder(), 'currency', 'sValiuta'],
            'warehouse on a transfer' => [new InternalTransferBuilder(), 'warehouse', 'fromWarehouse()'],
            'amount on a payment' => [new InflowBuilder(), 'amount', 'addLine('],
        ];
    }

    #[DataProvider('removedBuilderMethods')]
    public function test_a_removed_builder_method_explains_itself(object $builder, string $method, string $hint): void
    {
        try {
            $builder->{$method}('X');
            $this->fail('Expected LogicException');
        } catch (LogicException $e) {
            $this->assertStringContainsString("{$method}() was removed in v4", $e->getMessage());
            $this->assertStringContainsString($hint, $e->getMessage());
        }

        $this->assertFalse(method_exists($builder, $method), 'method_exists() guards must keep working');
    }

    public function test_an_unknown_builder_method_is_still_an_ordinary_error(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Call to undefined method');

        (new SaleBuilder())->noSuchMethod();
    }

    public function test_a_retired_name_on_a_builder_that_never_had_it_is_an_ordinary_error(): void
    {
        // amount() was a v3 payment setter; SaleBuilder never had one.
        $this->expectException(BadMethodCallException::class);

        (new SaleBuilder())->amount(5);
    }

    public function test_v3_named_arguments_still_work(): void
    {
        // Named arguments are part of the public API: v3 spelled these
        // employee(name:) and warehouse(warehouseCode:).
        foreach ([
            new CapitalizationBuilder(), new WriteOffBuilder(),
            new ClearingBuilder(), new ProductionBuilder(),
            new UvmCancellationBuilder(),
        ] as $builder) {
            $builder->employee(name: 'JONAS');
            $this->assertSame('JONAS', (fn () => $this->header['sDarbuotojas'])->call($builder), $builder::class);
        }

        $count = (new InventoryCountBuilder())->warehouse(warehouseCode: 'CENTR.');
        $this->assertSame('CENTR.', (fn () => $this->header['sSandelis'])->call($count));
    }
}
