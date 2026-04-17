<?php

declare(strict_types=1);

namespace Finvalda\Tests;

use DateTimeImmutable;
use Finvalda\Enums\OpClass;
use Finvalda\Query\OperationQuery;
use PHPUnit\Framework\TestCase;

class OperationQueryTest extends TestCase
{
    public function test_it_builds_structured_payload_with_filter_nested(): void
    {
        $query = OperationQuery::sales()
            ->journal('PARD')
            ->number(123)
            ->series('HTL')
            ->orderNumber('027987')
            ->client('ACME')
            ->warehouse('01')
            ->product('SKU-1')
            ->object1('OBJ1')
            ->dateRange('2024-01-01', '2024-12-31')
            ->modifiedSince(new DateTimeImmutable('2024-06-15'));

        $payload = $query->build();

        $this->assertSame(OpClass::Sales, $query->opClass());
        $this->assertFalse($payload['fullOp']);
        $this->assertArrayHasKey('filter', $payload);

        $filter = $payload['filter'];
        $this->assertSame('PARD', $filter['Journal']);
        $this->assertSame(123, $filter['OpNumber']);
        $this->assertSame('HTL', $filter['Series']);
        $this->assertSame('027987', $filter['OrderNumber']);
        $this->assertSame('ACME', $filter['Client']);
        $this->assertSame('01', $filter['Warehouse']);
        $this->assertSame('SKU-1', $filter['GoodsCode']);
        $this->assertSame('OBJ1', $filter['Object1']);
        $this->assertSame('2024-01-01', $filter['OpDateFrom']);
        $this->assertSame('2024-12-31', $filter['OpDateTill']);
        $this->assertSame('2024-06-15', $filter['DateEditedFrom']);
    }

    public function test_it_uses_corrected_date_keys_not_legacy_names(): void
    {
        $filter = OperationQuery::sales()
            ->dateFrom('2024-01-01')
            ->dateTo('2024-12-31')
            ->modifiedSince('2024-06-15')
            ->build()['filter'];

        $this->assertArrayNotHasKey('DateFrom', $filter);
        $this->assertArrayNotHasKey('DateTo', $filter);
        $this->assertArrayNotHasKey('DateEdited', $filter);

        $this->assertSame('2024-01-01', $filter['OpDateFrom']);
        $this->assertSame('2024-12-31', $filter['OpDateTill']);
        $this->assertSame('2024-06-15', $filter['DateEditedFrom']);
    }

    public function test_product_emits_goods_code_not_product(): void
    {
        $filter = OperationQuery::sales()->product('ABC')->build()['filter'];

        $this->assertArrayNotHasKey('Product', $filter);
        $this->assertSame('ABC', $filter['GoodsCode']);
    }

    public function test_number_emits_op_number_not_number(): void
    {
        $filter = OperationQuery::sales()->number(42)->build()['filter'];

        $this->assertArrayNotHasKey('Number', $filter);
        $this->assertSame(42, $filter['OpNumber']);
    }

    public function test_columns_and_columns_det_wrap_in_column_key(): void
    {
        $payload = OperationQuery::sales()
            ->fullOp()
            ->columns('op_number', 'op_date', 'amount')
            ->columnsDet('code', 'title', 'quantity')
            ->build();

        $this->assertTrue($payload['fullOp']);
        $this->assertSame(['column' => ['op_number', 'op_date', 'amount']], $payload['columns']);
        $this->assertSame(['column' => ['code', 'title', 'quantity']], $payload['columnsDet']);
    }

    public function test_columns_are_omitted_when_not_set(): void
    {
        $payload = OperationQuery::sales()->build();

        $this->assertArrayNotHasKey('columns', $payload);
        $this->assertArrayNotHasKey('columnsDet', $payload);
    }

    public function test_filter_bucket_is_always_present_even_when_empty(): void
    {
        $payload = OperationQuery::sales()->build();

        $this->assertSame([], $payload['filter']);
    }

    public function test_for_class_accepts_any_opclass(): void
    {
        $query = OperationQuery::forClass(OpClass::GeneralLedger);

        $this->assertSame(OpClass::GeneralLedger, $query->opClass());
    }

    public function test_factory_methods_return_correct_opclass(): void
    {
        $this->assertSame(OpClass::Sales, OperationQuery::sales()->opClass());
        $this->assertSame(OpClass::SalesDet, OperationQuery::salesDetail()->opClass());
        $this->assertSame(OpClass::Purchases, OperationQuery::purchases()->opClass());
        $this->assertSame(OpClass::PurchasesDet, OperationQuery::purchasesDetail()->opClass());
        $this->assertSame(OpClass::Inflows, OperationQuery::inflows()->opClass());
        $this->assertSame(OpClass::InflowsDet, OperationQuery::inflowsDetail()->opClass());
        $this->assertSame(OpClass::Disbursement, OperationQuery::disbursement()->opClass());
        $this->assertSame(OpClass::DisbursementDet, OperationQuery::disbursementDetail()->opClass());
    }
}
