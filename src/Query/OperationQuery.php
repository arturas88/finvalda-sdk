<?php

declare(strict_types=1);

namespace Finvalda\Query;

use DateTimeInterface;
use Finvalda\Enums\OpClass;

/**
 * Fluent query builder for operation queries (GetOperations).
 *
 * Usage:
 * ```php
 * $query = OperationQuery::sales()
 *     ->journal('PARD')
 *     ->dateRange('2024-01-01', '2024-12-31')
 *     ->number(123);
 *
 * $results = $finvalda->operations()->query($query->opClass(), $query->build());
 * ```
 */
final class OperationQuery extends QueryBuilder
{
    private OpClass $opClass;

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

    // --- Query parameters ---

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
        return $this->set('Number', $number);
    }

    /**
     * Filter by document series.
     */
    public function series(string $series): self
    {
        return $this->set('Series', $series);
    }

    /**
     * Filter by client code.
     */
    public function client(string $code): self
    {
        return $this->set('Client', $code);
    }

    /**
     * Filter by warehouse code.
     */
    public function warehouse(string $code): self
    {
        return $this->set('Warehouse', $code);
    }

    /**
     * Filter by product code.
     */
    public function product(string $code): self
    {
        return $this->set('Product', $code);
    }

    /**
     * Filter by operation date range.
     */
    public function dateRange(
        DateTimeInterface|string|null $from,
        DateTimeInterface|string|null $to,
    ): self {
        $this->setDate('DateFrom', $from);
        $this->setDate('DateTo', $to);

        return $this;
    }

    /**
     * Filter by operation date from.
     */
    public function dateFrom(DateTimeInterface|string $date): self
    {
        return $this->setDate('DateFrom', $date);
    }

    /**
     * Filter by operation date to.
     */
    public function dateTo(DateTimeInterface|string $date): self
    {
        return $this->setDate('DateTo', $date);
    }

    /**
     * Filter by modification date.
     */
    public function modifiedSince(DateTimeInterface|string $date): self
    {
        return $this->setDate('DateEdited', $date);
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
}
