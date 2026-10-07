<?php

declare(strict_types=1);

namespace Finvalda\Laravel\Facades;

use Finvalda\Builders\CapitalizationBuilder;
use Finvalda\Builders\ClearingBuilder;
use Finvalda\Builders\DisbursementBuilder;
use Finvalda\Builders\InflowBuilder;
use Finvalda\Builders\InternalTransferBuilder;
use Finvalda\Builders\InventoryCountBuilder;
use Finvalda\Builders\NonAnalyticalBuilder;
use Finvalda\Builders\ProductionBuilder;
use Finvalda\Builders\PurchaseBuilder;
use Finvalda\Builders\PurchaseOrderBuilder;
use Finvalda\Builders\PurchaseReturnBuilder;
use Finvalda\Builders\PurchaseUpdateBuilder;
use Finvalda\Builders\SaleBuilder;
use Finvalda\Builders\SalesReservationBuilder;
use Finvalda\Builders\SalesReturnBuilder;
use Finvalda\Builders\UvmCancellationBuilder;
use Finvalda\Builders\UvmPurchaseOrderBuilder;
use Finvalda\Builders\UvmSalesReservationBuilder;
use Finvalda\Builders\WriteOffBuilder;
use Finvalda\Enums\CredentialMode;
use Finvalda\HttpClient;
use Finvalda\Recording\Exchange;
use Finvalda\Resources\Clients;
use Finvalda\Resources\Descriptions;
use Finvalda\Resources\Documents;
use Finvalda\Resources\Objects;
use Finvalda\Resources\Operations;
use Finvalda\Resources\OrderManagement;
use Finvalda\Resources\Permissions;
use Finvalda\Resources\Pricing;
use Finvalda\Resources\Products;
use Finvalda\Resources\References;
use Finvalda\Resources\Reports;
use Finvalda\Resources\Services;
use Finvalda\Resources\Stock;
use Finvalda\Resources\Transactions;
use Illuminate\Support\Facades\Facade;
use Psr\Log\LoggerInterface;

/**
 * @method static Stock stock()
 * @method static Clients clients()
 * @method static Products products()
 * @method static Services services()
 * @method static Objects objects()
 * @method static References references()
 * @method static Pricing pricing()
 * @method static Operations operations()
 * @method static OrderManagement orderManagement()
 * @method static Documents documents()
 * @method static Reports reports()
 * @method static Descriptions descriptions()
 * @method static Permissions permissions()
 * @method static Transactions transactions()
 * @method static SaleBuilder sale()
 * @method static SalesReservationBuilder salesReservation()
 * @method static SalesReturnBuilder salesReturn()
 * @method static PurchaseBuilder purchase()
 * @method static PurchaseOrderBuilder purchaseOrder()
 * @method static PurchaseReturnBuilder purchaseReturn()
 * @method static PurchaseUpdateBuilder purchaseUpdate()
 * @method static InternalTransferBuilder internalTransfer()
 * @method static WriteOffBuilder writeOff()
 * @method static CapitalizationBuilder capitalization()
 * @method static InventoryCountBuilder inventoryCount()
 * @method static InflowBuilder inflow()
 * @method static DisbursementBuilder disbursement()
 * @method static ClearingBuilder clearing()
 * @method static ProductionBuilder production()
 * @method static NonAnalyticalBuilder nonAnalytical()
 * @method static UvmSalesReservationBuilder uvmSalesReservation()
 * @method static UvmCancellationBuilder uvmCancellation()
 * @method static UvmPurchaseOrderBuilder uvmPurchaseOrder()
 * @method static \Finvalda\Finvalda withCompany(?string $companyId)
 * @method static \Finvalda\Finvalda withoutCompany()
 * @method static \Finvalda\Finvalda setLogger(?LoggerInterface $logger)
 * @method static \Finvalda\Finvalda record(int $limit = 20, CredentialMode $credentials = CredentialMode::Masked)
 * @method static \Finvalda\Finvalda stopRecording()
 * @method static list<Exchange> recordings()
 * @method static Exchange|null lastRecording()
 * @method static bool ping()
 * @method static HttpClient getHttpClient()
 *
 * @see \Finvalda\Finvalda
 */
class Finvalda extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Finvalda\Finvalda::class;
    }
}
