# Finvalda PHP SDK

PHP SDK for the [Finvalda (FVS)](https://www.finvalda.lt/) accounting software web service API.

Built from the official [Finvalda API documentation](https://documenter.getpostman.com/view/7208231/2s8YmRMLvd).

## Requirements

- PHP >= 8.3
- Guzzle HTTP client

## Installation

```bash
composer require arturas88/finvalda-sdk
```

## Configuration

```php
use Finvalda\Finvalda;
use Finvalda\FinvaldaConfig;
use Finvalda\Enums\Language;

$config = new FinvaldaConfig(
    baseUrl: 'https://your-server.com/FvsServicePure.svc',
    username: 'your-username',
    password: 'your-password',
    // Optional:
    connString: null,           // Database connection string
    companyId: null,            // Company ID for multi-database setups
    language: Language::Lithuanian, // or Language::English
    removeEmptyStringTags: false,
    removeZeroNumberTags: false,
    removeNewLines: false,
    timeout: 30,
);

$finvalda = new Finvalda($config);
```

### Laravel Integration

The package auto-registers via Laravel package discovery. Add your credentials to `.env`:

```env
FINVALDA_BASE_URL=https://your-server.com/FvsServicePure.svc
FINVALDA_USERNAME=your-username
FINVALDA_PASSWORD=your-password
FINVALDA_COMPANY_ID=your-company-id
```

Publish the config file (optional):

```bash
php artisan vendor:publish --tag=finvalda-config
```

Then inject or use the facade:

```php
// Dependency injection
public function index(Finvalda\Finvalda $finvalda)
{
    $clients = $finvalda->clients()->list();
}

// Facade
use Finvalda\Laravel\Facades\Finvalda;

$clients = Finvalda::clients()->list();
```

### Custom HTTP Client (Testing)

You can inject a custom Guzzle client for testing or custom configuration:

```php
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

$mock = new MockHandler([
    new Response(200, [], json_encode(['AccessResult' => 'Success', 'items' => []])),
]);

$httpClient = new \Finvalda\HttpClient($config, new Client(['handler' => HandlerStack::create($mock)]));
```

## Usage

All methods return a `Response` object with:
- `$response->successful()` - whether the request succeeded
- `$response->data` - the response data array
- `$response->error` - error message if failed
- `$response->raw` - full raw response array

### Stock / Inventory

```php
// Current stock balances
$response = $finvalda->stock()->balances();
$response = $finvalda->stock()->balances(productCode: 'PROD001', warehouseCode: 'WH01');

// Extended balances (includes product type, tags)
$response = $finvalda->stock()->balancesExtended();

// Balances with selling prices
$response = $finvalda->stock()->balancesWithPrices(includeZeroQuantity: true);

// Balances by warehouse group
$response = $finvalda->stock()->balancesByGroup(warehouseGroupCode: 'GROUP1');

// Ordered products
$response = $finvalda->stock()->orderedProducts();
```

### Clients

```php
// List clients
$response = $finvalda->clients()->list();
$response = $finvalda->clients()->list(modifiedSince: '2024-01-01');

// Get single client
$response = $finvalda->clients()->get('CLIENT001');

// All clients (with optional date filters)
$response = $finvalda->clients()->all();
$response = $finvalda->clients()->all(modifiedSince: '2024-01-01');

// Client email
$response = $finvalda->clients()->email('CLIENT001');

// Client types and tags
$response = $finvalda->clients()->typesAndTags();

// Clients by type
$response = $finvalda->clients()->byType('VIP');

// Accounts (with full filter support)
$response = $finvalda->clients()->accounts(clientCode: 'CLIENT001');
$response = $finvalda->clients()->accounts(
    clientCode: 'CLIENT001',
    journalGroup: 'PARD',
    debtType: 1,
    documentDateFrom: '2024-01-01',
    documentDateTo: '2024-12-31',
);

// Unpaid documents (sales and purchases)
$response = $finvalda->clients()->unpaidDocuments('CLIENT001');
$response = $finvalda->clients()->unpaidPurchaseDocuments('CLIENT001');

// Client debt condition
$response = $finvalda->clients()->debtCondition('CLIENT001', journalGroup: 'PARD');

// Settlements (with journal/number support)
$response = $finvalda->clients()->settlements(series: 'SER', document: 'DOC001');
$response = $finvalda->clients()->settlements(journal: 'PARD', number: 123);

// Detailed settlements
$response = $finvalda->clients()->settlementsDetailed(
    series: 'SER',
    document: 'DOC001',
    operationId: 1,
    operationClass: 2,
);

// Settlements from date
$response = $finvalda->clients()->settlementsFromDate(
    series: 'SER',
    document: 'DOC001',
    modifiedSince: '2024-01-01',
);

// Settlements with XML parameter
$response = $finvalda->clients()->settlementsFromDateParam('<params>...</params>');

// Create / update client
$result = $finvalda->clients()->create([
    'sKodas' => 'NEW001',
    'sPavadinimas' => 'New Client Ltd',
    'sDebtSask' => '2410',
    'sKredSask' => '5001',
    'sPvmMokKod' => 'LT',
]);

$result = $finvalda->clients()->update([
    'sKodas' => 'NEW001',
    'sPavadinimas' => 'Updated Client Name',
]);

// Delete a client
$result = $finvalda->clients()->delete('CLIENT001');

// Invoices related to a customer
$response = $finvalda->clients()->invoicesRelatedToCustomer('CLIENT001', debtType: 0);
```

### Products

```php
// List products
$response = $finvalda->products()->list();

// Extended list with filters
$response = $finvalda->products()->listExtended(
    type: 'ELECTRONICS',
    supplier1: 'SUPP01',
    modifiedSince: '2024-01-01',
);

// Single product
$response = $finvalda->products()->get('PROD001');

// All products (with optional date filters)
$response = $finvalda->products()->all(modifiedSince: '2024-01-01');

// Product image
$response = $finvalda->products()->image('PROD001');

// Products in warehouse (with date filters)
$response = $finvalda->products()->inWarehouse('WH01', modifiedSince: '2024-01-01');
$response = $finvalda->products()->inWarehouseOrdered('WH01', order: 1);

// Types, tags, and type groups
$response = $finvalda->products()->typesAndTags();
$response = $finvalda->products()->typeGroups();
$response = $finvalda->products()->typeGroupComposition('GRP01');

// Product history
$response = $finvalda->products()->history('PROD001', dateFrom: '2024-01-01');

// Sold products per period
$response = $finvalda->products()->soldPerPeriod(
    productCode: 'PROD001',
    warehouseCode: 'WH01',
    dateFrom: '2024-01-01',
    dateTo: '2024-12-31',
    salesJournalCode: 'PARD',
);

// Create / update
$result = $finvalda->products()->create([
    'sKodas' => 'NEWPROD',
    'sPavadinimas' => 'New Product',
    'sRysysSuSask' => '2414',
    'sMatavimoVnt' => 'vnt',
    'sMokestis' => 'PVM1',
]);

// Update a product
$result = $finvalda->products()->update([
    'sKodas' => 'PROD001',
    'sPavadinimas' => 'Updated Product Name',
]);

// Batch edit properties
$result = $finvalda->products()->editProperties('PROD001', [
    'dKaina1' => 19.99,
    'sRusis' => 'ELECTRONICS',
]);

// Delete a product
$result = $finvalda->products()->delete('PROD001');
```

### Services

```php
$response = $finvalda->services()->list();
$response = $finvalda->services()->get('SVC001');
$response = $finvalda->services()->all(modifiedSince: '2024-01-01');
$response = $finvalda->services()->typesAndTags();
$response = $finvalda->services()->byType('CONSULTING');

$result = $finvalda->services()->create([
    'sKodas' => 'NEWSVC',
    'sPavadinimas' => 'New Service',
    'sRysysSuSask' => '5001',
    'sMokestis' => 'PVM1',
]);

$result = $finvalda->services()->update(['sKodas' => 'SVC001', 'sPavadinimas' => 'Updated']);
$result = $finvalda->services()->delete('SVC001');
```

### Objects (6 Levels)

```php
// List objects at level 1-6
$response = $finvalda->objects()->list(level: 1);
$response = $finvalda->objects()->list(level: 2, objectCode: 'OBJ001');

// Get single object
$response = $finvalda->objects()->get(level: 1, objectCode: 'OBJ001');

// Create / update
$result = $finvalda->objects()->create(level: 1, data: [
    'sKodas' => 'DEPT01',
    'sPavadinimas' => 'Sales Department',
]);

$result = $finvalda->objects()->update(level: 1, data: [
    'sKodas' => 'DEPT01',
    'sPavadinimas' => 'Updated Department',
]);
```

### Transactions (Financial Detail Data)

Read transaction details using typed filter DTOs:

```php
use Finvalda\Filters\TransactionFilter;
use Finvalda\Filters\PaymentFilter;

// Create a reusable filter
$filter = new TransactionFilter(
    dateFrom: '2024-01-01',
    dateTo: '2024-12-31',
    journalGroup: 'PARD_GRP',
);

// Sales (headers, detail lines, detail with prime cost)
$response = $finvalda->transactions()->sales($filter);
$response = $finvalda->transactions()->salesDetail(new TransactionFilter(journal: 'PARD', opNumber: 123));
$response = $finvalda->transactions()->salesDetailWithPrimeCost($filter);

// Sale Reservations
$response = $finvalda->transactions()->saleReservations($filter);
$response = $finvalda->transactions()->saleReservationsDetail($filter);

// Sales Returns
$response = $finvalda->transactions()->salesReturns($filter);
$response = $finvalda->transactions()->salesReturnsDetail($filter);

// DateTimeInterface is also accepted
$filter = new TransactionFilter(
    dateFrom: new \DateTime('2024-01-01'),
    dateTo: new \DateTimeImmutable('2024-12-31'),
);

// Purchases (headers, detail, extended detail)
$response = $finvalda->transactions()->purchases($filter);
$response = $finvalda->transactions()->purchasesDetail($filter);
$response = $finvalda->transactions()->purchasesExtendedDetail($filter);

// Purchase Orders & Returns (headers + detail)
$response = $finvalda->transactions()->purchaseOrders($filter);
$response = $finvalda->transactions()->purchaseOrdersDetail($filter);
$response = $finvalda->transactions()->purchaseReturns($filter);
$response = $finvalda->transactions()->purchaseReturnsDetail($filter);

// Inflows with payment reference filter
$response = $finvalda->transactions()->inflowsDetail(
    filter: $filter,
    paymentFilter: new PaymentFilter(
        payedForDocSeries: 'AA',
        payedForDocOrderNumber: 'SF-001',
    ),
);

// Advance Payments (standard + extended)
$response = $finvalda->transactions()->advancedPaymentsDetail(
    filter: $filter,
    client: 'CLIENT001',
    offsetStatus: 0,
);
$response = $finvalda->transactions()->advancedPaymentsDetailExtended(filter: $filter);

// Disbursements, Clearing Offsets
$response = $finvalda->transactions()->disbursementsDetail($filter);
$response = $finvalda->transactions()->clearingOffsDetail($filter);

// OMM (Order Management Module) — sales + purchases, headers + detail
$response = $finvalda->transactions()->ommSales($filter);
$response = $finvalda->transactions()->ommSalesDetail($filter);
$response = $finvalda->transactions()->ommSalesXmlCondition('<condition>...</condition>');
$response = $finvalda->transactions()->ommSalesXmlConditionWithTitle('<condition>...</condition>');
$response = $finvalda->transactions()->ommPurchases($filter);
$response = $finvalda->transactions()->ommPurchasesDetail($filter);

// Fixed Assets & Currency
$response = $finvalda->transactions()->depreciationOfFixedAssets(year: 2024, month: 6);
$response = $finvalda->transactions()->depreciationOfFixedAssetsObjects(assetCode: 'ASSET01');
$response = $finvalda->transactions()->currencyDebtRecount($filter);

// Low Value Inventory
$response = $finvalda->transactions()->lowValueInventory();
```

### Operations (Create, Update, Delete)

```php
use Finvalda\Enums\OperationClass;
use Finvalda\Enums\DeleteOperationClass;
use Finvalda\Enums\UpdateOperationClass;
use Finvalda\Enums\OpClass;

// Create a sale
$result = $finvalda->operations()->create(OperationClass::Sale, [
    'sKlientas' => 'CLIENT001',
    'tData' => '2024-06-15',
    'sDokumentas' => 'SF-001',
    'sValiuta' => 'EUR',
    'sSerija' => 'AA',
    'PardDokPrekeDetEil' => [
        [
            'sKodas' => 'PROD001',
            'sSandelis' => 'WH01',
            'nKiekis' => 10,
            'dSumaV' => 199.90,
            'dSumaL' => 199.90,
        ],
    ],
]);

if ($result->success) {
    echo "Created: {$result->journal} #{$result->number}";
}

// Create a purchase
$result = $finvalda->operations()->create(OperationClass::Purchase, [
    'sKlientas' => 'SUPPLIER001',
    'tData' => '2024-06-15',
    'sDokumentas' => 'PO-001',
    'sValiuta' => 'EUR',
    'PirkDokPrekeDetEil' => [
        [
            'sKodas' => 'PROD001',
            'sSandelis' => 'WH01',
            'nKiekis' => 100,
            'dSumaV' => 500.00,
            'dSumaL' => 500.00,
        ],
    ],
]);

// Create an internal transfer
$result = $finvalda->operations()->create(OperationClass::InternalTransfer, [
    'tData' => '2024-06-15',
    'VidPerkDokDetEil' => [
        [
            'sKodas' => 'PROD001',
            'sSandelisIs' => 'WH01',
            'sSandelisI' => 'WH02',
            'nKiekis' => 50,
        ],
    ],
]);

// Delete an operation
$result = $finvalda->operations()->delete(
    DeleteOperationClass::Sale,
    journal: 'PARD',
    number: 123,
);

// Update an operation
$result = $finvalda->operations()->update(UpdateOperationClass::Sale, [
    'sZurnalas' => 'PARD',
    'nNumeris' => 123,
    'PardDokHeadEil' => [
        'sPastaba' => 'Updated comment',
    ],
]);

// Read operations with filters (via GetOperations)
$response = $finvalda->operations()->get(OpClass::Sales, [
    'OpDateFrom' => '2024-01-01',
    'OpDateTill' => '2024-12-31',
    'Client' => 'CLIENT001',
]);

// Read with JSON body (supports complex filters, column selection, fullOp)
$response = $finvalda->operations()->query(OpClass::Sales, [
    'OpDateFrom' => '2024-01-01',
    'OpDateTill' => '2024-12-31',
    'fullOp' => true,
    'columns' => ['sKlientas', 'tData', 'sDokumentas'],
]);

// Lock / unlock operations
$finvalda->operations()->lock('PARD', 123);
$finvalda->operations()->unlock('PARD', 123);
$response = $finvalda->operations()->isLocked('PARD', 123);

// Change journal of an operation
$result = $finvalda->operations()->changeJournal([
    'sZurnalas' => 'PARD',
    'nNumeris' => 123,
    'sNaujasZurnalas' => 'PARD2',
]);

// Copy an operation
$result = $finvalda->operations()->copy([
    'sZurnalas' => 'PARD',
    'nNumeris' => 123,
]);

// Activity report by objects
$response = $finvalda->operations()->activityByObjects([
    'DateFrom' => '2024-01-01',
    'DateTo' => '2024-12-31',
]);
```

### Order Management (UVM)

```php
// Sales reservation status by journal + number
$response = $finvalda->orderManagement()->salesReservationStatus('PARD', 123);

// List reservations with date range filters
$response = $finvalda->orderManagement()->completedReservations(
    journalGroup: 'PARD_GRP',
    dateFrom: '2024-01-01',
    dateTo: '2024-12-31',
);
$response = $finvalda->orderManagement()->pendingReservations();
$response = $finvalda->orderManagement()->cancelledReservations();

// Ordered products from reservations
$response = $finvalda->orderManagement()->orderedProducts(dateFrom: '2024-01-01');
```

### Pricing & Discounts

All pricing methods support `modifiedSince` and `createdSince` date filters.

```php
// Combined client + item prices (discounts and additional prices)
$response = $finvalda->pricing()->clientItemPrices(clientCode: 'CLI001', itemCode: 'PROD001');
$response = $finvalda->pricing()->clientTypeItemPrices(clientTypeCode: 'VIP', itemCode: 'PROD001');
$response = $finvalda->pricing()->clientItemTypePrices(clientCode: 'CLI001', itemTypeCode: 'ELECTRONICS');
$response = $finvalda->pricing()->clientTypeItemTypePrices(
    clientTypeCode: 'VIP',
    itemTypeCode: 'ELECTRONICS',
);

// Product-specific (client + product, client + product type)
$response = $finvalda->pricing()->clientProductDiscounts('CLI001', modifiedSince: '2024-01-01');
$response = $finvalda->pricing()->clientProductAdditionalPrices('CLI001');
$response = $finvalda->pricing()->clientProductTypeDiscounts('CLI001');
$response = $finvalda->pricing()->clientProductTypeAdditionalPrices('CLI001');

// Service-specific (client + service, client + service type)
$response = $finvalda->pricing()->clientServiceDiscounts('CLI001');
$response = $finvalda->pricing()->clientServiceAdditionalPrices('CLI001');
$response = $finvalda->pricing()->clientServiceTypeDiscounts('CLI001');
$response = $finvalda->pricing()->clientServiceTypeAdditionalPrices('CLI001');

// Client TYPE + product/service
$response = $finvalda->pricing()->clientTypeProductDiscounts('VIP');
$response = $finvalda->pricing()->clientTypeProductAdditionalPrices('VIP');
$response = $finvalda->pricing()->clientTypeProductTypeDiscounts('VIP');
$response = $finvalda->pricing()->clientTypeProductTypeAdditionalPrices('VIP');

// Client TYPE + service
$response = $finvalda->pricing()->clientTypeServiceDiscounts('VIP');
$response = $finvalda->pricing()->clientTypeServiceAdditionalPrices('VIP');
$response = $finvalda->pricing()->clientTypeServiceTypeDiscounts('VIP');
$response = $finvalda->pricing()->clientTypeServiceTypeAdditionalPrices('VIP');

// Recommended price calculation
$response = $finvalda->pricing()->recommendedPrice([
    'invoiceType' => 0, // 0=sales, 1=purchases
    'invoiceDate' => ['year' => 2024, 'month' => 6, 'day' => 15],
    'itemType' => 1,    // 1=product, 2=service
    'itemCode' => 'PROD001',
    'itemAmount' => 10,
    'warehouseCode' => 'WH01',
    'clientCode' => 'CLI001',
]);
```

### Documents

```php
use Finvalda\Enums\DocumentEntityType;

// Upload from file path
$result = $finvalda->documents()->uploadFile('invoice.pdf', '/path/to/invoice.pdf');

// Upload hex-encoded content directly
$result = $finvalda->documents()->upload('doc.pdf', $hexContent);

// Attach to entity
$result = $finvalda->documents()->attach(
    DocumentEntityType::Sale,
    entityCode: 'CLI001',
    filename: 'invoice.pdf',
    journal: 'PARD',
    number: 123,
);

// Get attached documents
$response = $finvalda->documents()->attached(DocumentEntityType::Client, 'CLI001');

// Delete
$result = $finvalda->documents()->delete('invoice.pdf');
```

### Reports & Invoices

```php
// Generate invoice PDF (sParam contains serialized operation selection)
$response = $finvalda->reports()->makeInvoice('param_string');

// Generate report PDF
$response = $finvalda->reports()->makeReport('param_string');

// List auto-reports
$response = $finvalda->reports()->autoReports();
$response = $finvalda->reports()->autoReport('report_filename.pdf');
```

### Descriptions (Universal Query)

```php
use Finvalda\Enums\DescriptionType;

// Generic query with pagination and column selection
$response = $finvalda->descriptions()->get(DescriptionType::Products, [
    'Codes' => ['PROD001', 'PROD002'],
], page: 1, limit: 50);

// Convenience methods
$response = $finvalda->descriptions()->stockOnDate('2024-06-15', ['Warehouse' => 'WH01']);
$response = $finvalda->descriptions()->products(['Type' => 'ELECTRONICS'], page: 1, limit: 100);
$response = $finvalda->descriptions()->clients(['Email' => 'client@example.com']);
$response = $finvalda->descriptions()->services();
$response = $finvalda->descriptions()->currentStock(['Warehouse' => 'WH01']);
$response = $finvalda->descriptions()->fixedAssets();
$response = $finvalda->descriptions()->barCodes(['Codes' => ['PROD001']]);
$response = $finvalda->descriptions()->prices(['Client' => 'CLI001']);
$response = $finvalda->descriptions()->currencyRates('2024-01-01', '2024-12-31', ['USD', 'GBP']);
$response = $finvalda->descriptions()->clientGroups();
$response = $finvalda->descriptions()->warehouseGroups();
$response = $finvalda->descriptions()->logbookGroups();
$response = $finvalda->descriptions()->opTypeGroups();
$response = $finvalda->descriptions()->vehicles();
$response = $finvalda->descriptions()->calendarEvents('admin');
$response = $finvalda->descriptions()->documentSeries(type: 0);
$response = $finvalda->descriptions()->invoiceList();
$response = $finvalda->descriptions()->reportList('Pardavimai');
$response = $finvalda->descriptions()->tagsAndTypes('product', 0);
```

### Reference Data

```php
$response = $finvalda->references()->measurementUnits();
$response = $finvalda->references()->warehouses();
$response = $finvalda->references()->taxes();
$response = $finvalda->references()->paymentTerms();
$response = $finvalda->references()->user();
$response = $finvalda->references()->materiallyResponsiblePersons(code: 'EMP01');

// Create reference entities
$result = $finvalda->references()->createBank(['sKodas' => 'BNK01', 'sPavadinimas' => 'My Bank']);
$result = $finvalda->references()->createWarehouse(['sKodas' => 'WH03', 'sPavadinimas' => 'Warehouse 3']);
$result = $finvalda->references()->createPaymentTerm(['sKodas' => 'NET30', 'sPavadinimas' => 'Net 30']);
$result = $finvalda->references()->createClientType(['sKodas' => 'VIP', 'sPavadinimas' => 'VIP Clients']);
$result = $finvalda->references()->createProductType(['sKodas' => 'ELEC', 'sPavadinimas' => 'Electronics']);

// Update reference entities
$result = $finvalda->references()->updateWarehouse(['sKodas' => 'WH03', 'sPavadinimas' => 'Updated']);
$result = $finvalda->references()->updatePaymentTerm(['sKodas' => 'NET30', 'sPavadinimas' => 'Updated']);

// Add item to group
$result = $finvalda->references()->addToGroup('Fvs.PrekesRusis', 'GRP01', 'PROD001');
```

### User Permissions

```php
$response = $finvalda->permissions()->warehouses();
$response = $finvalda->permissions()->clients();
$response = $finvalda->permissions()->operationTypes();
$response = $finvalda->permissions()->operationJournals();

// Or by class ID directly
$response = $finvalda->permissions()->get(65); // warehouses
```

## Error Handling

```php
use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Exceptions\AccessDeniedException;

try {
    $response = $finvalda->clients()->list();

    if ($response->failed()) {
        echo "Error: {$response->error}";
    }
} catch (AccessDeniedException $e) {
    echo "Access denied: {$e->getMessage()}";
} catch (FinvaldaException $e) {
    echo "API error: {$e->getMessage()}";
}
```

For write operations (`create`, `update`, `delete`), the `OperationResult` object provides:

```php
$result = $finvalda->operations()->create(OperationClass::Sale, $data);

if ($result->success) {
    echo "Series: {$result->series}";
    echo "Document: {$result->document}";
    echo "Journal: {$result->journal}";
    echo "Number: {$result->number}";
} else {
    echo "Error #{$result->errorCode}: {$result->error}";
}
```

## API Versions

This SDK targets **V2 (FvsServicePure)** - the recommended REST interface that returns clean JSON/XML. Configure `baseUrl` accordingly:

| Version | URL Pattern | Description |
|---------|-------------|-------------|
| V2 (recommended) | `.../FvsServicePure.svc` | Clean REST JSON/XML |
| V1 | `.../FvsServiceR.svc/rest` | REST with string-wrapped responses |
| V0 | `.../FvsService.asmx` | SOAP + REST XML |

## Keeping Up to Date

The SDK is built from the [official Postman collection](https://documenter.getpostman.com/view/7208231/2s8YmRMLvd). To check for new endpoints:

```bash
bin/sync-postman-collection
```

This compares the latest online collection with the local copy and reports new/removed endpoints.

## License

MIT
