<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
use Finvalda\Filters\PaymentFilter;
use Finvalda\Filters\TransactionFilter;
use Finvalda\Responses\Response;

/**
 * Financial transaction detail endpoints (WsData).
 *
 * All methods accept a TransactionFilter for common parameters (journal, date range, etc.).
 * Payment-related methods additionally accept a PaymentFilter for paid-for document references.
 *
 * @see TransactionFilter for common filter parameters
 * @see PaymentFilter for payment reference parameters
 */
final class Transactions extends Resource
{
    // --- Sales ---

    /** Get sales operation headers. */
    public function sales(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetSales', $this->params($filter));
    }

    /** Get sales detail lines (products, services per operation). */
    public function salesDetail(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetSalesDet', $this->params($filter));
    }

    /** Get sales detail lines with prime cost (savikaina). */
    public function salesDetailWithPrimeCost(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetSalesDetWithPrimeCost', $this->params($filter));
    }

    // --- Sale Reservations ---

    /** Get sale reservation headers. */
    public function saleReservations(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetSaleReservations', $this->params($filter));
    }

    /** Get sale reservation detail lines. */
    public function saleReservationsDetail(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetSaleReservationsDet', $this->params($filter));
    }

    // --- Sales Returns ---

    /** Get sales return headers. */
    public function salesReturns(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetSalesReturns', $this->params($filter));
    }

    /** Get sales return detail lines. */
    public function salesReturnsDetail(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetSalesReturnsDet', $this->params($filter));
    }

    // --- Purchases ---

    /** Get purchase operation headers. */
    public function purchases(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetPurchases', $this->params($filter));
    }

    /** Get purchase detail lines. */
    public function purchasesDetail(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetPurchasesDet', $this->params($filter));
    }

    /** Get purchase extended detail lines (includes additional fields). */
    public function purchasesExtendedDetail(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetPurchasesExtDet', $this->params($filter));
    }

    // --- Purchase Orders ---

    /** Get purchase order headers. */
    public function purchaseOrders(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetPurchaseOrders', $this->params($filter));
    }

    /** Get purchase order detail lines. */
    public function purchaseOrdersDetail(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetPurchaseOrdersDet', $this->params($filter));
    }

    // --- Purchase Returns ---

    /** Get purchase return headers. */
    public function purchaseReturns(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetPurchaseReturns', $this->params($filter));
    }

    /** Get purchase return detail lines. */
    public function purchaseReturnsDetail(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetPurchaseReturnsDet', $this->params($filter));
    }

    // --- Inflows (Payments Received) ---

    /**
     * Get inflow (payment received) detail lines.
     *
     * @param PaymentFilter|null $paymentFilter Filter by the document that was paid for
     */
    public function inflowsDetail(?TransactionFilter $filter = null, ?PaymentFilter $paymentFilter = null): Response
    {
        return $this->http->get('GetInflowsDet', array_merge(
            $this->params($filter),
            $paymentFilter?->toParams() ?? [],
        ));
    }

    // --- Advanced Payments ---

    /**
     * Get advance payment detail lines.
     *
     * @param string|null $client Client code filter
     * @param int|null $offsetStatus Offset status filter (0=not offset, 1=offset)
     */
    public function advancedPaymentsDetail(
        ?TransactionFilter $filter = null,
        ?PaymentFilter $paymentFilter = null,
        ?string $client = null,
        ?int $offsetStatus = null,
    ): Response {
        return $this->http->get('GetAdvancedPaymentsDet', array_merge(
            $this->params($filter),
            $paymentFilter?->toParams() ?? [],
            ['sClient' => $client, 'nOffsetStatus' => $offsetStatus],
        ));
    }

    /**
     * Get advance payment extended detail lines (includes additional fields).
     *
     * @param string|null $client Client code filter
     * @param int|null $offsetStatus Offset status filter (0=not offset, 1=offset)
     */
    public function advancedPaymentsDetailExtended(
        ?TransactionFilter $filter = null,
        ?PaymentFilter $paymentFilter = null,
        ?string $client = null,
        ?int $offsetStatus = null,
    ): Response {
        return $this->http->get('GetAdvancedPaymentsDetExt', array_merge(
            $this->params($filter),
            $paymentFilter?->toParams() ?? [],
            ['sClient' => $client, 'nOffsetStatus' => $offsetStatus],
        ));
    }

    // --- Disbursements (Payments Out) ---

    /** Get disbursement (payment out) detail lines. */
    public function disbursementsDetail(?TransactionFilter $filter = null, ?PaymentFilter $paymentFilter = null): Response
    {
        return $this->http->get('GetDisbursementsDet', array_merge(
            $this->params($filter),
            $paymentFilter?->toParams() ?? [],
        ));
    }

    // --- Clearing Offsets ---

    /** Get clearing offset detail lines. */
    public function clearingOffsDetail(?TransactionFilter $filter = null, ?PaymentFilter $paymentFilter = null): Response
    {
        return $this->http->get('GetClearingOffsDet', array_merge(
            $this->params($filter),
            $paymentFilter?->toParams() ?? [],
        ));
    }

    // --- OMM (Order Management Module) ---

    /** Get OMM sales headers. */
    public function ommSales(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetOMMSales', $this->params($filter));
    }

    /** Get OMM sales detail lines. */
    public function ommSalesDetail(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetOMMSalesDet', $this->params($filter));
    }

    /**
     * Get OMM sales filtered by XML condition.
     *
     * @param string $xmlData XML condition string
     */
    public function ommSalesXmlCondition(string $xmlData): Response
    {
        return $this->http->get('GetOMMSalesXmlCond', ['sXmlData' => $xmlData]);
    }

    /**
     * Get OMM sales filtered by XML condition, including operation title.
     *
     * @param string $xmlData XML condition string
     */
    public function ommSalesXmlConditionWithTitle(string $xmlData): Response
    {
        return $this->http->get('GetOMMSalesXmlCondOpTitle', ['sXmlData' => $xmlData]);
    }

    /** Get OMM purchase headers. */
    public function ommPurchases(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetOMMPurchases', $this->params($filter));
    }

    /** Get OMM purchase detail lines. */
    public function ommPurchasesDetail(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetOMMPurchasesDet', $this->params($filter));
    }

    // --- Currency & Assets ---

    /** Get currency debt recount operations. */
    public function currencyDebtRecount(?TransactionFilter $filter = null): Response
    {
        return $this->http->get('GetCurrencyDebtRecount', $this->params($filter));
    }

    /**
     * Get fixed asset depreciation records.
     *
     * @param string|null $assetCode Fixed asset code
     * @param int|null $year Depreciation year
     * @param int|null $month Depreciation month (1-12)
     */
    public function depreciationOfFixedAssets(
        ?TransactionFilter $filter = null,
        ?string $assetCode = null,
        ?int $year = null,
        ?int $month = null,
    ): Response {
        return $this->http->get('GetDepreciationOfFixedAssets', array_merge(
            $this->params($filter),
            ['sAssetCode' => $assetCode, 'nYear' => $year, 'nMonth' => $month],
        ));
    }

    /**
     * Get fixed asset depreciation records broken down by objects.
     *
     * @param string|null $assetCode Fixed asset code
     * @param int|null $year Depreciation year
     * @param int|null $month Depreciation month (1-12)
     */
    public function depreciationOfFixedAssetsObjects(
        ?TransactionFilter $filter = null,
        ?string $assetCode = null,
        ?int $year = null,
        ?int $month = null,
    ): Response {
        return $this->http->get('GetDepreciationOfFixedAssetsObjects', array_merge(
            $this->params($filter),
            ['sAssetCode' => $assetCode, 'nYear' => $year, 'nMonth' => $month],
        ));
    }

    // --- Low Value Inventory ---

    /** Get low value inventory list. */
    public function lowValueInventory(): Response
    {
        return $this->http->get('GetLowValueInventory');
    }

    // --- Helpers ---

    private function params(?TransactionFilter $filter): array
    {
        return $filter?->toParams() ?? [];
    }
}
