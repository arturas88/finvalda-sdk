<?php

declare(strict_types=1);

namespace Finvalda\Query;

use DateTimeInterface;
use Finvalda\Enums\OpClass;

/**
 * Fluent query builder for operation queries (GetOperations).
 *
 * Builds the `opReadParams` JSON body expected by GetOperations:
 * ```
 * {
 *   "fullOp": false,
 *   "filter": { "Journal": "...", "OpDateFrom": "...", ... },
 *   "columns":    { "column": [...] },
 *   "columnsDet": { "column": [...] }
 * }
 * ```
 *
 * Usage:
 * ```php
 * $query = OperationQuery::sales()
 *     ->journal('PARD')
 *     ->dateRange('2024-01-01', '2024-12-31')
 *     ->number(123)
 *     ->columns('op_number', 'op_date', 'amount');
 *
 * $results = $finvalda->operations()->query($query->opClass(), $query->build());
 * ```
 */
final class OperationQuery extends QueryBuilder
{
    private OpClass $opClass;

    private bool $fullOp = false;

    /** @var array<int, string> */
    private array $columns = [];

    /** @var array<int, string> */
    private array $columnsDet = [];

    private function __construct(OpClass $class)
    {
        $this->opClass = $class;
    }

    /**
     * Get the operation class.
     */
    public function opClass(): OpClass
    {
        return $this->opClass;
    }

    // --- Factory methods for common operation types ---

    public static function sales(): self
    {
        return new self(OpClass::Sales);
    }

    public static function salesDetail(): self
    {
        return new self(OpClass::SalesDet);
    }

    public static function purchases(): self
    {
        return new self(OpClass::Purchases);
    }

    public static function purchasesDetail(): self
    {
        return new self(OpClass::PurchasesDet);
    }

    public static function inflows(): self
    {
        return new self(OpClass::Inflows);
    }

    public static function inflowsDetail(): self
    {
        return new self(OpClass::InflowsDet);
    }

    public static function disbursement(): self
    {
        return new self(OpClass::Disbursement);
    }

    public static function disbursementDetail(): self
    {
        return new self(OpClass::DisbursementDet);
    }

    public static function internalTransactions(): self
    {
        return new self(OpClass::InternalTransactions);
    }

    public static function internalTransactionsDetail(): self
    {
        return new self(OpClass::InternalTransactionsDet);
    }

    /**
     * Create with any operation class.
     */
    public static function forClass(OpClass $class): self
    {
        return new self($class);
    }

    // --- Filter parameters (nested under "filter" in the payload) ---

    /**
     * Filter by journal code.
     */
    public function journal(string $code): self
    {
        return $this->set('Journal', $code);
    }

    /**
     * Filter by operation number.
     */
    public function number(int $number): self
    {
        return $this->set('OpNumber', $number);
    }

    /**
     * Filter by document series.
     */
    public function series(string $series): self
    {
        return $this->set('Series', $series);
    }

    /**
     * Filter by document order number.
     */
    public function orderNumber(string $orderNumber): self
    {
        return $this->set('OrderNumber', $orderNumber);
    }

    /**
     * Filter by client code.
     */
    public function client(string $code): self
    {
        return $this->set('Client', $code);
    }

    /**
     * Filter by client group code.
     */
    public function clientGroup(string $code): self
    {
        return $this->set('ClientGroup', $code);
    }

    /**
     * Filter by operation type.
     */
    public function opType(string $code): self
    {
        return $this->set('OpType', $code);
    }

    /**
     * Filter by operation type group.
     */
    public function opTypeGroup(string $code): self
    {
        return $this->set('OpTypeGroup', $code);
    }

    /**
     * Filter by warehouse code.
     */
    public function warehouse(string $code): self
    {
        return $this->set('Warehouse', $code);
    }

    /**
     * Filter by product/goods code.
     */
    public function product(string $code): self
    {
        return $this->set('GoodsCode', $code);
    }

    /**
     * Filter by operation date range.
     */
    public function dateRange(
        DateTimeInterface|string|null $from,
        DateTimeInterface|string|null $to,
    ): self {
        $this->setDate('OpDateFrom', $from);
        $this->setDate('OpDateTill', $to);

        return $this;
    }

    /**
     * Filter by operation date from.
     */
    public function dateFrom(DateTimeInterface|string $date): self
    {
        return $this->setDate('OpDateFrom', $date);
    }

    /**
     * Filter by operation date to.
     */
    public function dateTo(DateTimeInterface|string $date): self
    {
        return $this->setDate('OpDateTill', $date);
    }

    /**
     * Filter by modification date.
     */
    public function modifiedSince(DateTimeInterface|string $date): self
    {
        return $this->setDate('DateEditedFrom', $date);
    }

    /**
     * Filter by journal group.
     */
    public function journalGroup(string $group): self
    {
        return $this->set('JournalGroup', $group);
    }

    /**
     * Filter by analytical object level 1.
     */
    public function object1(string $code): self
    {
        return $this->set('Object1', $code);
    }

    /**
     * Filter by analytical object level 2.
     */
    public function object2(string $code): self
    {
        return $this->set('Object2', $code);
    }

    /**
     * Filter by analytical object level 3.
     */
    public function object3(string $code): self
    {
        return $this->set('Object3', $code);
    }

    /**
     * Filter by analytical object level 4.
     */
    public function object4(string $code): self
    {
        return $this->set('Object4', $code);
    }

    /**
     * Filter by analytical object level 5.
     */
    public function object5(string $code): self
    {
        return $this->set('Object5', $code);
    }

    /**
     * Filter by analytical object level 6.
     */
    public function object6(string $code): self
    {
        return $this->set('Object6', $code);
    }

    // --- Payload-level parameters (not inside "filter") ---

    /**
     * Return operation headers together with detail lines in a single response.
     */
    public function fullOp(bool $value = true): self
    {
        $this->fullOp = $value;

        return $this;
    }

    /**
     * Select which header columns to return. Required by the API — an empty
     * columns list produces a "Value cannot be null" error.
     */
    public function columns(string ...$names): self
    {
        $this->columns = array_values(array_unique(array_merge($this->columns, $names)));

        return $this;
    }

    /**
     * Select which detail columns to return. Only used when fullOp is true
     * or when the OpClass is a *Det variant.
     */
    public function columnsDet(string ...$names): self
    {
        $this->columnsDet = array_values(array_unique(array_merge($this->columnsDet, $names)));

        return $this;
    }

    /**
     * Build the `opReadParams` payload (without the OpClass, which is passed
     * separately to Operations::query()).
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $payload = [
            'fullOp' => $this->fullOp,
            'filter' => array_filter($this->params, fn ($v) => $v !== null),
        ];

        if ($this->columns !== []) {
            $payload['columns'] = ['column' => $this->columns];
        }

        if ($this->columnsDet !== []) {
            $payload['columnsDet'] = ['column' => $this->columnsDet];
        }

        return $payload;
    }
}
