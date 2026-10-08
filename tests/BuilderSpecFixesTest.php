<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Builders\CapitalizationBuilder;
use Finvalda\Builders\ClearingBuilder;
use Finvalda\Builders\DisbursementBuilder;
use Finvalda\Builders\InflowBuilder;
use Finvalda\Builders\InternalTransferBuilder;
use Finvalda\Builders\InventoryCountBuilder;
use Finvalda\Builders\ProductionBuilder;
use Finvalda\Builders\ProductLine;
use Finvalda\Builders\PurchaseBuilder;
use Finvalda\Builders\PurchaseUpdateBuilder;
use Finvalda\Builders\SaleBuilder;
use Finvalda\Builders\ServiceLine;
use Finvalda\Builders\WriteOffBuilder;
use Finvalda\Enums\ClearingDocumentType;
use Finvalda\Enums\DeleteOperationClass;
use Finvalda\Enums\OperationClass;
use Finvalda\Enums\PaymentType;
use Finvalda\Exceptions\ValidationException;
use PHPUnit\Framework\TestCase;

/**
 * Regression tests for builder output that did not match docs/FVS_Webservice.md.
 * Each test pins one fix; BuilderSpecConformanceTest guards the field names.
 */
class BuilderSpecFixesTest extends TestCase
{
    // --- Payments (IplDok / IsmDok) ---

    public function test_inflow_lines_are_nested_inside_the_ipl_dok_wrapper(): void
    {
        $data = (new InflowBuilder())
            ->client('CLI001')
            ->date('2024-01-15')
            ->currency('EUR')
            ->type(PaymentType::Documents)
            ->payDocument('SF', '000123', 500.00)
            ->build();

        $this->assertSame(['IplDok'], array_keys($data));
        $this->assertSame(3, $data['IplDok']['nTipas']);
        $this->assertSame(
            [['dSumaV' => 500.00, 'sSerija' => 'SF', 'sDokumentas' => '000123']],
            $data['IplDok']['IplDokDetEil'],
        );
    }

    public function test_paying_a_document_defaults_the_type_to_documents(): void
    {
        $data = (new InflowBuilder())->client('C')->date('2024-01-15')->payDocument('SF', '1', 10.0)->build();

        $this->assertSame(PaymentType::Documents->value, $data['IplDok']['nTipas']);
    }

    public function test_an_explicit_payment_type_is_kept(): void
    {
        $data = (new InflowBuilder())->type(PaymentType::Fifo)->payDocument('SF', '1', 10.0)->build();

        $this->assertSame(PaymentType::Fifo->value, $data['IplDok']['nTipas']);
    }

    public function test_a_payment_without_a_type_is_refused(): void
    {
        // nTipas is required by the spec; without it the server picks a default
        // and may not settle the documents named on the lines.
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('nTipas');

        (new DisbursementBuilder())->client('C')->addLine(5.0)->build();
    }

    public function test_the_old_for_document_signature_is_refused_with_a_migration_hint(): void
    {
        // v3 took (document, journal, number, amount); v4 takes (series, document,
        // amount). An old call would still type-check and book the number as the
        // amount, so the old name is retired instead of reused.
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('payDocument(');

        (new InflowBuilder())->forDocument('SF-123', 'PARD', 42, 500.0);
    }

    public function test_disbursement_uses_the_ism_dok_envelope(): void
    {
        $builder = (new DisbursementBuilder())
            ->client('SUP001')
            ->date('2024-01-15')
            ->type(PaymentType::Advance)
            ->addLine(250.00, 'Advance');

        $this->assertSame(OperationClass::Disbursement, $builder->getOperationClass());
        $this->assertSame('IsmDok', OperationClass::Disbursement->value);
        $this->assertSame(
            ['IsmDok' => [
                'sKlientas' => 'SUP001',
                'tData' => '2024-01-15',
                'nTipas' => 0,
                'IsmDokDetEil' => [['dSumaV' => 250.00, 'sPavadinimas' => 'Advance']],
            ]],
            $builder->build(),
        );
    }

    public function test_payments_reject_generic_product_lines(): void
    {
        $this->expectException(\BadMethodCallException::class);

        (new InflowBuilder())->addProduct('PRD001', 1);
    }

    // --- Warehouse belongs on the line ---

    public function test_warehouse_is_a_line_default_and_a_line_value_wins(): void
    {
        $data = (new SaleBuilder())
            ->warehouse('MAIN')
            ->addProduct('A', 1)
            ->product(ProductLine::make('B', 1)->warehouse('OTHER'))
            ->build();

        $this->assertArrayNotHasKey('sSandelis', $data['PardDok']);
        $this->assertSame('MAIN', $data['PardDok']['PardDokPrekeDetEil'][0]['sSandelis']);
        $this->assertSame('OTHER', $data['PardDok']['PardDokPrekeDetEil'][1]['sSandelis']);
    }

    public function test_build_does_not_freeze_the_default_warehouse(): void
    {
        foreach ([[new SaleBuilder(), 'PardDok'], [new PurchaseBuilder(), 'PirkDok']] as [$builder, $header]) {
            $builder->warehouse('A')->addProduct('P', 1);
            $builder->build();

            $data = $builder->warehouse('B')->build();

            $this->assertSame('B', $data[$header][$header . 'PrekeDetEil'][0]['sSandelis'], $header);
        }
    }

    public function test_write_off_warehouse_is_a_line_default(): void
    {
        $data = (new WriteOffBuilder())->warehouse('MAIN')->addItem('A', 1)->build();

        $this->assertArrayNotHasKey('sSandelis', $data['NurasymasDok']);
        $this->assertSame('MAIN', $data['NurasymasDok']['NurasymasDokDetEil'][0]['sSandelis']);
    }

    // --- Unit price ---

    public function test_price_is_sent_as_the_spec_unit_price(): void
    {
        $line = (new SaleBuilder())->addProduct('A', 2, amount: 19.0, price: 9.5)->build()['PardDok']['PardDokPrekeDetEil'][0];

        $this->assertSame(9.5, $line['dSumaVntV']);
        $this->assertSame(19.0, $line['dSumaV']);
        $this->assertArrayNotHasKey('dKaina', $line);
    }

    public function test_a_sale_line_with_a_unit_price_but_no_amount_is_refused(): void
    {
        // Verified on the server (2026-10-07): a PardDok line carrying only
        // dSumaVntV is accepted and booked with amount 0. The amount comes from
        // dSumaV alone.
        foreach ([
            fn () => (new SaleBuilder())->product(ProductLine::make('A', 1)->price(1.23)),
            fn () => (new SaleBuilder())->service(ServiceLine::make('S', 1)->price(1.23)),
            fn () => (new SaleBuilder())->addProduct('A', 1, price: 1.23),
        ] as $make) {
            try {
                $make()->build();
                $this->fail('Expected ValidationException');
            } catch (ValidationException $e) {
                $this->assertStringContainsString('dSumaV', $e->getMessage());
            }
        }
    }

    public function test_a_purchase_refuses_a_unit_price_its_lines_cannot_hold(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('dSumaVntV');

        (new PurchaseBuilder())->product(ProductLine::make('A', 1)->amount(10)->price(10))->build();
    }

    public function test_a_sale_refuses_purchase_only_additional_costs_on_a_line(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('dPapIsldSumaV1');

        (new SaleBuilder())->product(ProductLine::make('A', 1)->additionalCost(1, 5.0))->build();
    }

    // --- Due date ---

    public function test_due_date_is_the_spec_payment_date(): void
    {
        $sale = (new SaleBuilder())->dueDate('2024-02-01')->build()['PardDok'];
        $purchase = (new PurchaseBuilder())->dueDate('2024-02-01')->build()['PirkDok'];

        $this->assertSame('2024-02-01', $sale['tMokejimoData']);
        $this->assertSame('2024-02-01', $purchase['tMokejimoData']);
        $this->assertArrayNotHasKey('tAtsiskData', $sale);
    }

    // --- First measurement on every stock line ---

    public function test_stock_movement_lines_default_to_the_first_measurement(): void
    {
        $writeOff = (new WriteOffBuilder())->addItem('A', 2.5)->build();
        $capitalization = (new CapitalizationBuilder())->addItem('A', 2.5, amount: 10)->build();
        $transfer = (new InternalTransferBuilder())->addTransfer('A', 2.5)->build();
        $production = (new ProductionBuilder())
            ->addFinishedGood('A', 'W', 2.5)
            ->addRawMaterial('B', 'W', 2.5)
            ->addProductionService('S', 1.0, 1)
            ->build();

        $this->assertSame(1, $writeOff['NurasymasDok']['NurasymasDokDetEil'][0]['nPirmasMat']);
        $this->assertSame(1, $capitalization['PajamavimasDok']['PajamavimasDokDetEil'][0]['nPirmasMat']);
        $this->assertSame(1, $transfer['VidPerkDok']['VidPerkDokDetEil'][0]['nPirmasMat']);
        $this->assertSame(1, $production['GamybaDok']['GamybaGDetEil'][0]['nPirmasMat']);
        $this->assertSame(1, $production['GamybaDok']['GamybaZDetEil'][0]['nPirmasMat']);
        $this->assertSame(1, $production['GamybaDok']['GamybaPDetEil'][0]['nPirmasMat']);
    }

    public function test_first_measurement_can_be_opted_out_of(): void
    {
        $data = (new WriteOffBuilder())->addItem('A', 250, additionalData: ['nPirmasMat' => 0])->build();

        $this->assertSame(0, $data['NurasymasDok']['NurasymasDokDetEil'][0]['nPirmasMat']);
    }

    // --- Short variants and series ---

    public function test_a_full_purchase_refuses_a_series_it_has_no_field_for(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('sSerija');

        (new PurchaseBuilder())->series('PF')->build();
    }

    public function test_an_empty_series_on_a_full_purchase_is_a_no_op(): void
    {
        // Consumers pass series('') unconditionally; an empty value carries no
        // series, so there is nothing to refuse.
        $data = (new PurchaseBuilder())->client('C')->series('')->build();

        $this->assertArrayNotHasKey('sSerija', $data['PirkDok']);
    }

    // --- Due date ---

    public function test_a_due_date_before_the_document_date_is_refused(): void
    {
        foreach ([new SaleBuilder(), new PurchaseBuilder()] as $builder) {
            try {
                $builder->date('2026-10-07')->dueDate('2026-10-06')->build();
                $this->fail('Expected ValidationException for ' . $builder::class);
            } catch (ValidationException $e) {
                $this->assertStringContainsString('2026-10-06', $e->getMessage());
                $this->assertStringContainsString('2026-10-07', $e->getMessage());
            }
        }
    }

    public function test_a_due_date_on_or_after_the_document_date_is_kept(): void
    {
        $data = (new SaleBuilder())->date('2026-10-07')->dueDate('2026-10-07')->build();

        $this->assertSame('2026-10-07', $data['PardDok']['tMokejimoData']);
    }

    public function test_a_short_sale_refuses_header_fields_outside_its_envelope(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('TrumpasPardDok does not accept sPastaba');

        (new SaleBuilder())->short()->client('C')->note('x')->build();
    }

    public function test_a_short_purchase_keeps_its_documented_fields(): void
    {
        $data = (new PurchaseBuilder())
            ->short()
            ->client('SUP')
            ->date('2024-01-15')
            ->currency('EUR')
            ->series('PF')
            ->documentNumber('1')
            ->build();

        $this->assertSame(
            ['sKlientas' => 'SUP', 'tData' => '2024-01-15', 'sValiuta' => 'EUR', 'sSerija' => 'PF', 'sDokumentas' => '1'],
            $data['TrumpasPirkDok'],
        );
    }

    // --- Lines on operations that have none of that kind ---

    public function test_write_off_rejects_generic_product_lines(): void
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('addItem()');

        (new WriteOffBuilder())->product(ProductLine::make('A', 1));
    }

    public function test_internal_transfer_rejects_generic_service_lines(): void
    {
        $this->expectException(\BadMethodCallException::class);

        (new InternalTransferBuilder())->service(ServiceLine::make('S', 1));
    }

    // --- Internal transfer warehouse pair ---

    public function test_add_transfer_refuses_to_reroute_earlier_lines(): void
    {
        $builder = (new InternalTransferBuilder())->addTransfer('A', 1, fromWarehouse: 'W1', toWarehouse: 'W2');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("'W1' is already set, 'W3' given");

        $builder->addTransfer('B', 1, fromWarehouse: 'W3');
    }

    public function test_add_transfer_accepts_the_same_warehouse_again(): void
    {
        $data = (new InternalTransferBuilder())
            ->addTransfer('A', 1, fromWarehouse: 'W1', toWarehouse: 'W2')
            ->addTransfer('B', 1, fromWarehouse: 'W1', toWarehouse: 'W2')
            ->build();

        $this->assertSame('W1', $data['VidPerkDok']['sIsSandelio']);
        $this->assertCount(2, $data['VidPerkDok']['VidPerkDokDetEil']);
    }

    // --- Clearing types ---

    public function test_clearing_accepts_the_type_enum(): void
    {
        $data = (new ClearingBuilder())
            ->addDebitLine(10, 'SF', '1', ClearingDocumentType::Sale)
            ->addCreditLine(10, 'PF', '2', ClearingDocumentType::Purchase)
            ->build();

        $this->assertSame(3, $data['UzskaitaDok']['UzskaitaDebitDetEil'][0]['nTipas']);
        $this->assertSame(2, $data['UzskaitaDok']['UzskaitaKreditDetEil'][0]['nTipas']);
    }

    public function test_clearing_refuses_a_type_from_the_other_side(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('not valid on the debit side');

        (new ClearingBuilder())->addDebitLine(10, 'PF', '2', 2);
    }

    public function test_clearing_accepts_inflow_and_disbursement_on_either_side(): void
    {
        // The spec rows name "Išmoka" (debit) and "Įplauka" (credit) but drop
        // their numbers, so 0/1 are inferred; until a server confirms which is
        // which, neither side refuses them.
        $data = (new ClearingBuilder())
            ->addDebitLine(10, 'A', '1', 0)
            ->addCreditLine(10, 'B', '2', 1)
            ->build();

        $this->assertSame(0, $data['UzskaitaDok']['UzskaitaDebitDetEil'][0]['nTipas']);
        $this->assertSame(1, $data['UzskaitaDok']['UzskaitaKreditDetEil'][0]['nTipas']);
    }

    public function test_clearing_refuses_an_unknown_type(): void
    {
        $this->expectException(ValidationException::class);

        (new ClearingBuilder())->addCreditLine(10, 'PF', '2', 9);
    }

    // --- Object levels ---

    public function test_object_levels_outside_one_to_six_are_refused_everywhere(): void
    {
        $attempts = [
            'ProductLine::object' => fn () => ProductLine::make('A', 1)->object(7, 'X'),
            'ProductLine::objects' => fn () => ProductLine::make('A', 1)->objects([0 => 'X']),
            'ServiceLine::object' => fn () => ServiceLine::make('A', 1)->object(7, 'X'),
            'SaleBuilder::objects' => fn () => (new SaleBuilder())->objects([7 => 'X']),
        ];

        foreach ($attempts as $label => $attempt) {
            try {
                $attempt();
                $this->fail("{$label} accepted level 7/0");
            } catch (ValidationException $e) {
                $this->assertStringContainsString('must be 1-6', $e->getMessage());
            }
        }
    }

    // --- Inventory count mode ---

    public function test_inventory_count_mode_must_be_zero_or_one(): void
    {
        $this->expectException(ValidationException::class);

        (new InventoryCountBuilder())->mode(2);
    }

    // --- Purchase correction lines ---

    public function test_purchase_correction_refuses_a_line_field_its_table_does_not_define(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('dPVM_Procentas');

        (new PurchaseUpdateBuilder())->product(
            ProductLine::make('A', 1)->warehouse('W')->amount(10)->vat(21)
        );
    }

    // --- Delete class mapping ---

    public function test_operation_class_maps_to_its_delete_class(): void
    {
        $this->assertSame(DeleteOperationClass::Sale, OperationClass::SaleShort->deleteClass());
        $this->assertSame(DeleteOperationClass::Inflow, OperationClass::Inflow->deleteClass());
        $this->assertSame(DeleteOperationClass::Production, OperationClass::Production->deleteClass());
        $this->assertNull(OperationClass::WriteOff->deleteClass());
        $this->assertNull(OperationClass::Disbursement->deleteClass());
    }
}
