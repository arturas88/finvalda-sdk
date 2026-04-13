<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use Finvalda\Builders\ProductLine;
use Finvalda\Builders\SaleBuilder;
use Finvalda\Builders\ServiceLine;
use Finvalda\Enums\OperationClass;
use PHPUnit\Framework\TestCase;

class LineTest extends TestCase
{
    // --- ProductLine ---

    public function test_product_line_basic(): void
    {
        $line = ProductLine::make('MILTAI', 12.25)->toArray();

        $this->assertSame('MILTAI', $line['sKodas']);
        $this->assertSame(12.25, $line['nKiekis']);
    }

    public function test_product_line_full(): void
    {
        $line = ProductLine::make('MILTAI', 12.25)
            ->warehouse('CENTR.')
            ->price(13.15)
            ->amount(161.16, local: 161.16)
            ->vat(percent: 21, amount: 33.84, amountLocal: 33.84)
            ->discount(percent: 5.0, amount: 8.48, amountLocal: 8.48)
            ->object(1, 'DEPT01')
            ->object(2, 'PROJ01')
            ->object(4, '1234567')
            ->vatCode('PVM21')
            ->intrastat('84713000', origin: 'LT')
            ->weight(neto: 25.5, bruto: 28.0, volume: 0.5)
            ->firstMeasurement()
            ->info('Test note')
            ->marked()
            ->toArray();

        $this->assertSame('MILTAI', $line['sKodas']);
        $this->assertSame(12.25, $line['nKiekis']);
        $this->assertSame('CENTR.', $line['sSandelis']);
        $this->assertSame(13.15, $line['dKaina']);
        $this->assertSame(161.16, $line['dSumaV']);
        $this->assertSame(161.16, $line['dSumaL']);
        $this->assertSame(21.0, $line['dPVM_Procentas']);
        $this->assertSame(33.84, $line['dSumaPVMV']);
        $this->assertSame(33.84, $line['dSumaPVML']);
        $this->assertSame(5.0, $line['dNlProc']);
        $this->assertSame(8.48, $line['dSumaNV']);
        $this->assertSame(8.48, $line['dSumaNL']);
        $this->assertSame('DEPT01', $line['sObjektas1']);
        $this->assertSame('PROJ01', $line['sObjektas2']);
        $this->assertArrayNotHasKey('sObjektas3', $line);
        $this->assertSame('1234567', $line['sObjektas4']);
        $this->assertSame('PVM21', $line['sPvmKodas']);
        $this->assertSame('84713000', $line['sIntrastatKodas']);
        $this->assertSame('LT', $line['sKilmesSalis']);
        $this->assertSame(25.5, $line['dNeto']);
        $this->assertSame(28.0, $line['dBruto']);
        $this->assertSame(0.5, $line['dTuris']);
        $this->assertSame(1, $line['nPirmasMat']);
        $this->assertSame('Test note', $line['sPapInf']);
        $this->assertSame(1, $line['nPozymis']);
    }

    public function test_product_line_sparse_objects(): void
    {
        $line = ProductLine::make('A', 1)
            ->objects([1 => 'DEPT01', 4 => '1234567', 6 => 'ZONE3'])
            ->toArray();

        $this->assertSame('DEPT01', $line['sObjektas1']);
        $this->assertArrayNotHasKey('sObjektas2', $line);
        $this->assertArrayNotHasKey('sObjektas3', $line);
        $this->assertSame('1234567', $line['sObjektas4']);
        $this->assertArrayNotHasKey('sObjektas5', $line);
        $this->assertSame('ZONE3', $line['sObjektas6']);
    }

    public function test_product_line_amount_defaults_local_to_currency(): void
    {
        $line = ProductLine::make('A', 1)->amount(100.00)->toArray();

        $this->assertSame(100.00, $line['dSumaV']);
        $this->assertSame(100.00, $line['dSumaL']);
    }

    public function test_product_line_vat_amount_defaults_local(): void
    {
        $line = ProductLine::make('A', 1)->vat(21, amount: 10.50)->toArray();

        $this->assertSame(10.50, $line['dSumaPVMV']);
        $this->assertSame(10.50, $line['dSumaPVML']);
    }

    public function test_product_line_set_escape_hatch(): void
    {
        $line = ProductLine::make('A', 1)
            ->set('sAtitSer', 'CERT-001')
            ->set('tGalData', '2025-12-31')
            ->toArray();

        $this->assertSame('CERT-001', $line['sAtitSer']);
        $this->assertSame('2025-12-31', $line['tGalData']);
    }

    // --- ServiceLine ---

    public function test_service_line_basic(): void
    {
        $line = ServiceLine::make('TRANSPORT', 1)->toArray();

        $this->assertSame('TRANSPORT', $line['sKodas']);
        $this->assertSame(1.0, $line['nKiekis']);
    }

    public function test_service_line_full(): void
    {
        $line = ServiceLine::make('TRANSPORT', 1)
            ->price(50.00)
            ->amount(50.00, local: 50.00)
            ->vat(percent: 21, amount: 10.50, amountLocal: 10.50)
            ->discount(percent: 10.0)
            ->object(1, 'DEPT01')
            ->vatCode('PVM21')
            ->firstMeasurement()
            ->info('Delivery')
            ->marked()
            ->toArray();

        $this->assertSame('TRANSPORT', $line['sKodas']);
        $this->assertSame(50.00, $line['dKaina']);
        $this->assertSame(50.00, $line['dSumaV']);
        $this->assertSame(21.0, $line['dPVM_Procentas']);
        $this->assertSame(10.50, $line['dSumaPVMV']);
        $this->assertSame(10.0, $line['dNlProc']);
        $this->assertSame('DEPT01', $line['sObjektas1']);
        $this->assertSame('PVM21', $line['sPvmKodas']);
        $this->assertSame(1, $line['nPirmasMat']);
        $this->assertSame('Delivery', $line['sPapInf']);
        $this->assertSame(1, $line['nPozymis']);
    }

    // --- Builder integration ---

    public function test_builder_product_method_adds_line(): void
    {
        $builder = new SaleBuilder();
        $data = $builder
            ->client('CLI001')
            ->date('2024-01-15')
            ->currency('EUR')
            ->product(
                ProductLine::make('MILTAI', 12.25)
                    ->warehouse('CENTR.')
                    ->amount(161.16, local: 161.16)
                    ->vat(percent: 21, amount: 33.84, amountLocal: 33.84)
                    ->firstMeasurement()
            )
            ->product(
                ProductLine::make('PIENAS', 5)
                    ->warehouse('CENTR.')
                    ->amount(25.00)
                    ->vat(percent: 21)
                    ->object(1, 'DEPT01')
                    ->object(4, '1234567')
            )
            ->build();

        $this->assertSame('CLI001', $data['PardDok']['sKlientas']);
        $this->assertCount(2, $data['PardDok']['PardDokPrekeDetEil']);
        $this->assertSame('MILTAI', $data['PardDok']['PardDokPrekeDetEil'][0]['sKodas']);
        $this->assertSame(1, $data['PardDok']['PardDokPrekeDetEil'][0]['nPirmasMat']);
        $this->assertSame('PIENAS', $data['PardDok']['PardDokPrekeDetEil'][1]['sKodas']);
        $this->assertSame('DEPT01', $data['PardDok']['PardDokPrekeDetEil'][1]['sObjektas1']);
        $this->assertSame('1234567', $data['PardDok']['PardDokPrekeDetEil'][1]['sObjektas4']);
        $this->assertArrayNotHasKey('sObjektas2', $data['PardDok']['PardDokPrekeDetEil'][1]);
    }

    public function test_builder_service_method_adds_line(): void
    {
        $builder = new SaleBuilder();
        $data = $builder
            ->client('CLI001')
            ->date('2024-01-15')
            ->currency('EUR')
            ->service(
                ServiceLine::make('TRANSPORT', 1)
                    ->amount(50.00)
                    ->vat(percent: 21, amount: 10.50)
            )
            ->build();

        $this->assertCount(1, $data['PardDok']['PardDokPaslaugaDetEil']);
        $this->assertSame('TRANSPORT', $data['PardDok']['PardDokPaslaugaDetEil'][0]['sKodas']);
        $this->assertSame(50.00, $data['PardDok']['PardDokPaslaugaDetEil'][0]['dSumaV']);
        $this->assertSame(10.50, $data['PardDok']['PardDokPaslaugaDetEil'][0]['dSumaPVMV']);
    }

    public function test_builder_mixes_dto_and_legacy_methods(): void
    {
        $builder = new SaleBuilder();
        $data = $builder
            ->client('CLI001')
            ->date('2024-01-15')
            ->currency('EUR')
            ->product(
                ProductLine::make('A', 1)->warehouse('W1')->amount(10.00)->vat(percent: 21)
            )
            ->addProduct('B', quantity: 2, price: 5.00, warehouse: 'W1')
            ->service(
                ServiceLine::make('S1', 1)->amount(20.00)->vat(percent: 21)
            )
            ->addService('S2', quantity: 1, price: 15.00)
            ->build();

        $this->assertCount(2, $data['PardDok']['PardDokPrekeDetEil']);
        $this->assertSame('A', $data['PardDok']['PardDokPrekeDetEil'][0]['sKodas']);
        $this->assertSame('B', $data['PardDok']['PardDokPrekeDetEil'][1]['sKodas']);
        $this->assertCount(2, $data['PardDok']['PardDokPaslaugaDetEil']);
        $this->assertSame('S1', $data['PardDok']['PardDokPaslaugaDetEil'][0]['sKodas']);
        $this->assertSame('S2', $data['PardDok']['PardDokPaslaugaDetEil'][1]['sKodas']);
    }
}
