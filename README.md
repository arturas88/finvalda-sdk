# Finvalda PHP SDK

PHP SDK for the [Finvalda (FVS)](https://www.finvalda.lt/) accounting software web service API.

Built from the official [Finvalda API documentation](https://documenter.getpostman.com/view/7208231/2s8YmRMLvd).

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Configuration](#configuration)
  - [Basic Configuration](#basic-configuration)
  - [Laravel Integration](#laravel-integration)
  - [Logging](#logging)
  - [Retry Policy](#retry-policy)
  - [Custom HTTP Client](#custom-http-client-testing)
- [Typed DTOs & Collections](#typed-dtos--collections)
  - [Finding Entities](#finding-entities)
  - [Working with Collections](#working-with-collections)
- [Fluent Operation Builders](#fluent-operation-builders)
  - [Sales](#creating-a-sale)
  - [Purchases](#creating-a-purchase)
  - [Internal Transfers](#creating-an-internal-transfer)
  - [Returns](#creating-returns)
  - [Payments](#creating-payments)
- [Query Builders](#query-builders)
  - [Transaction Query](#transaction-query)
  - [Operation Query](#operation-query)
- [Validation](#validation)
- [Resources](#resources)
  - [Stock / Inventory](#stock--inventory)
  - [Clients](#clients)
  - [Products](#products)
  - [Services](#services)
  - [Objects (6 Levels)](#objects-6-levels)
  - [Transactions](#transactions-financial-detail-data)
  - [Operations](#operations-create-update-delete)
  - [Order Management (UVM)](#order-management-uvm)
  - [Pricing & Discounts](#pricing--discounts)
  - [Documents](#documents)
  - [Reports & Invoices](#reports--invoices)
  - [Descriptions (Universal Query)](#descriptions-universal-query)
  - [Reference Data](#reference-data)
  - [User Permissions](#user-permissions)
- [Pagination](#pagination)
- [Error Handling](#error-handling)
- [Server-Configured Parameters](#server-configured-parameters)
- [API Versions](#api-versions)
- [License](#license)

## Requirements

- PHP >= 8.3
- Guzzle HTTP client

## Installation

```bash
composer require arturas88/finvalda-sdk
```

## Quick Start

```php
use Finvalda\Finvalda;
use Finvalda\FinvaldaConfig;

// Configure the client
$config = new FinvaldaConfig(
    baseUrl: 'https://your-server.com/FvsServicePure.svc',
    username: 'your-username',
    password: 'your-password',
);

$finvalda = new Finvalda($config);

// Fetch all clients as a typed collection
$clients = $finvalda->clients()->collect();

foreach ($clients as $client) {
    echo "{$client->code}: {$client->name}\n";
}

// Create a sale using the fluent builder
$result = $finvalda->sale()
    ->client('CLI001')
    ->date('2024-01-15')
    ->warehouse('MAIN')
    ->addProduct('PRD001', quantity: 10, price: 19.99)
    ->addProduct('PRD002', quantity: 5, amount: 49.95)
    ->save('STANDARD');

if ($result->success) {
    echo "Created: {$result->journal} #{$result->number}";
}
```

## Configuration

### Basic Configuration

```php
use Finvalda\Finvalda;
use Finvalda\FinvaldaConfig;
use Finvalda\Enums\Language;
use Finvalda\Retry\RetryPolicy;

$config = new FinvaldaConfig(
    baseUrl: 'https://your-server.com/FvsServicePure.svc',
    username: 'your-username',
    password: 'your-password',
    // Optional parameters:
    connString: null,                    // Database connection string
    companyId: null,                     // Company ID for multi-database setups
    language: Language::Lithuanian,      // or Language::English
    removeEmptyStringTags: false,
    removeZeroNumberTags: false,
    removeNewLines: false,
    timeout: 30,
    logger: null,                        // PSR-3 logger instance
    retry: null,                         // RetryPolicy instance
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
    $clients = $finvalda->clients()->collect();
}

// Facade
use Finvalda\Laravel\Facades\Finvalda;

$clients = Finvalda::clients()->collect();
```

### Logging

Enable PSR-3 logging for request/response debugging:

```php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Create a logger
$logger = new Logger('finvalda');
$logger->pushHandler(new StreamHandler('path/to/finvalda.log', Logger::DEBUG));

// Option 1: Pass in config
$config = new FinvaldaConfig(
    // ...
    logger: $logger,
);

// Option 2: Set after initialization
$finvalda->setLogger($logger);
```

Log output includes method, endpoint, parameters, status code, and response time.

### Retry Policy

Configure automatic retries for transient failures:

```php
use Finvalda\Retry\RetryPolicy;

// Default retry policy (3 attempts, 100ms initial delay, exponential backoff)
$config = new FinvaldaConfig(
    // ...
    retry: RetryPolicy::default(),
);

// Custom retry policy
$config = new FinvaldaConfig(
    // ...
    retry: new RetryPolicy(
        maxAttempts: 5,
        delayMs: 200,
        multiplier: 2.0,
        maxDelayMs: 10000,
        retryableStatusCodes: [429, 500, 502, 503, 504],
        retryOnNetworkError: true,
    ),
);

// Conservative policy (longer delays)
$config = new FinvaldaConfig(
    // ...
    retry: RetryPolicy::conservative(),
);

// Disable retries
$config = new FinvaldaConfig(
    // ...
    retry: RetryPolicy::noRetry(),
);
```

### Custom HTTP Client (Testing)

Inject a custom Guzzle client for testing or custom configuration:

```php
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

$mock = new MockHandler([
    new Response(200, [], json_encode(['AccessResult' => 'Success', 'items' => []])),
]);

$httpClient = new \Finvalda\HttpClient($config, new Client(['handler' => HandlerStack::create($mock)]));
$finvalda = new Finvalda($config, $httpClient);
```

## Typed DTOs & Collections

The SDK provides typed Data Transfer Objects for better IDE support and type safety.

### Finding Entities

Use `find()` to get a single entity as a typed DTO with full IDE autocomplete:

```php
use Finvalda\Data\Client;
use Finvalda\Data\Product;
use Finvalda\Data\Service;
use Finvalda\Exceptions\NotFoundException;

// Find a client - returns typed Client DTO
$client = $finvalda->clients()->find('CLI001');
echo $client->name;           // Full IDE autocomplete
echo $client->email;
echo $client->vatCode;
echo $client->debt;

// Find a product
$product = $finvalda->products()->find('PRD001');
echo $product->name;
echo $product->price1;
echo $product->barcode;
echo $product->supplier1;

// Find a service
$service = $finvalda->services()->find('SVC001');
echo $service->name;
echo $service->price;

// Handle not found
try {
    $client = $finvalda->clients()->find('NONEXISTENT');
} catch (NotFoundException $e) {
    echo "Client not found";
}

// Access raw API data if needed
$rawData = $client->raw;
$specificField = $client['sSpecialField']; // ArrayAccess supported
```

### Working with Collections

Use `collect()` to get typed collections with powerful filtering and transformation methods:

```php
use Finvalda\Collections\ClientCollection;
use Finvalda\Collections\ProductCollection;

// Get all clients as a typed collection
$clients = $finvalda->clients()->collect();

// Filter clients with debt
$debtors = $clients->withDebt();
$totalDebt = $clients->totalDebt();

// Filter by type
$vipClients = $clients->whereType('VIP');

// Find by code within collection
$client = $clients->findByCode('CLI001');

// Get products
$products = $finvalda->products()->collect();

// Filter by type
$electronics = $products->whereType('ELECTRONICS');

// Filter by supplier
$fromSupplier = $products->whereSupplier('SUP001');

// Products with stock
$inStock = $products->withStock();

// Filter by tag
$tagged = $products->whereTag(1, 'FEATURED');

// Find by barcode
$product = $products->findByBarcode('1234567890123');

// Collection methods work on all collections
$clients->count();                    // Count items
$clients->isEmpty();                  // Check if empty
$clients->isNotEmpty();               // Check if not empty
$clients->first();                    // Get first item
$clients->last();                     // Get last item
$clients->get(5);                     // Get by index
$clients->all();                      // Get as array

// Filtering and mapping
$filtered = $clients->filter(fn($c) => $c->debt > 1000);
$names = $clients->map(fn($c) => $c->name);
$codes = $clients->pluck('code');

// Iteration
foreach ($clients as $client) {
    echo "{$client->code}: {$client->name}\n";
}

// Execute callback for each
$clients->each(function($client) {
    sendReminder($client);
});

// Group by field
$byType = $clients->groupBy(fn($c) => $c->type);
foreach ($byType as $type => $typeClients) {
    echo "{$type}: {$typeClients->count()} clients\n";
}

// Convert to array
$array = $clients->toArray();

// Date filtering
$recentClients = $finvalda->clients()->collect(modifiedSince: '2024-01-01');
$newProducts = $finvalda->products()->collect(createdSince: '2024-06-01');
```

## Fluent Operation Builders

Create operations using an intuitive fluent interface instead of complex nested arrays.

### Creating a Sale

```php
// Fluent builder (new way)
$result = $finvalda->sale()
    ->client('CLI001')
    ->date('2024-01-15')
    ->warehouse('MAIN')
    ->currency('EUR')
    ->description('January order')
    ->documentNumber('ORD-2024-001')
    ->paymentDays(30)
    ->priceType(1)
    ->discount(5.0)
    ->object1('DEPT01')
    ->object2('PROJ01')
    ->addProduct('PRD001', quantity: 10, price: 19.99)
    ->addProduct('PRD002', quantity: 5, amount: 49.95)
    ->addService('SVC001', quantity: 2, price: 50.00)
    ->save('STANDARD');

// Equivalent array-based approach (old way - still supported)
$result = $finvalda->operations()->create(OperationClass::Sale, [
    'sKlientas' => 'CLI001',
    'tData' => '2024-01-15',
    'sSandelis' => 'MAIN',
    'sValiuta' => 'EUR',
    'sAprasymas' => 'January order',
    'sDokumentas' => 'ORD-2024-001',
    'nAtsiskDien' => 30,
    'nKainosTipas' => 1,
    'dNuolaida' => 5.0,
    'sObj1' => 'DEPT01',
    'sObj2' => 'PROJ01',
    'PardDokPrekeDetEil' => [
        ['sKodas' => 'PRD001', 'nKiekis' => 10, 'dKaina' => 19.99],
        ['sKodas' => 'PRD002', 'nKiekis' => 5, 'dSumaV' => 49.95],
    ],
    'PardDokPaslaugaDetEil' => [
        ['sKodas' => 'SVC001', 'nKiekis' => 2, 'dKaina' => 50.00],
    ],
], 'STANDARD');
```

### Creating a Purchase

```php
$result = $finvalda->purchase()
    ->client('SUP001')
    ->date('2024-01-15')
    ->warehouse('MAIN')
    ->currency('EUR')
    ->supplierInvoice('INV-2024-001')
    ->supplierInvoiceDate('2024-01-14')
    ->paymentDays(60)
    ->addProduct('PRD001', quantity: 100, price: 9.99)
    ->addProduct('PRD002', quantity: 50, price: 14.99)
    ->addService('FREIGHT', quantity: 1, amount: 150.00)
    ->save('STANDARD');
```

### Creating an Internal Transfer

```php
$result = $finvalda->internalTransfer()
    ->date('2024-01-15')
    ->fromWarehouse('MAIN')
    ->toWarehouse('BRANCH')
    ->description('Restock branch warehouse')
    ->addTransfer('PRD001', quantity: 50)
    ->addTransfer('PRD002', quantity: 25)
    ->addTransfer('PRD003', quantity: 100, fromWarehouse: 'MAIN', toWarehouse: 'BRANCH2')
    ->save('TRANSFER');
```

### Creating Returns

```php
// Sales return
$result = $finvalda->salesReturn()
    ->client('CLI001')
    ->date('2024-01-20')
    ->warehouse('MAIN')
    ->originalDocument('SF-001', 'PARD', 123)
    ->reason('Defective product')
    ->addProduct('PRD001', quantity: 2, price: 19.99)
    ->save('RETURN');

// Purchase return
$result = $finvalda->purchaseReturn()
    ->client('SUP001')
    ->date('2024-01-20')
    ->warehouse('MAIN')
    ->originalDocument('PO-001', 'PIRK', 456)
    ->reason('Wrong items delivered')
    ->addProduct('PRD001', quantity: 10, price: 9.99)
    ->save('RETURN');
```

### Creating Payments

```php
// Payment received (inflow)
$result = $finvalda->inflow()
    ->client('CLI001')
    ->date('2024-01-15')
    ->amount(500.00)
    ->currency('EUR')
    ->bankAccount('BANK01')
    ->description('Payment for invoice SF-001')
    ->forDocument('SF-001', 'PARD', 123, amount: 500.00)
    ->save('INFLOW');

// Payment out (disbursement)
$result = $finvalda->disbursement()
    ->client('SUP001')
    ->date('2024-01-15')
    ->amount(1000.00)
    ->currency('EUR')
    ->bankAccount('BANK01')
    ->description('Payment for purchase PO-001')
    ->forDocument('PO-001', 'PIRK', 456, amount: 1000.00)
    ->save('DISBURSEMENT');
```

### Builder Advanced Usage

```php
// Set the parameter once
$sale = $finvalda->sale()->parameter('STANDARD');

// Add custom header fields
$sale->setHeader('sCustomField', 'value');

// Add product lines with additional data
$sale->addProduct('PRD001', quantity: 10, price: 19.99, warehouse: 'WH01', additionalData: [
    'sLot' => 'LOT001',
    'tExpiryDate' => '2025-12-31',
]);

// Add raw product line
$sale->addProductLine([
    'sKodas' => 'PRD002',
    'nKiekis' => 5,
    'dKaina' => 29.99,
    'sSandelis' => 'WH01',
    'sSerialNumber' => 'SN12345',
]);

// Build without saving (for inspection)
$data = $sale->build();
print_r($data);

// Save
$result = $sale->save();
```

## Query Builders

Build queries fluently for better readability and IDE support.

### Transaction Query

```php
use Finvalda\Query\TransactionQuery;

// Create a fluent query
$query = TransactionQuery::create()
    ->journal('PARD')
    ->series('AA')
    ->dateRange('2024-01-01', '2024-12-31')
    ->modifiedSince('2024-06-01');

// Use with transactions resource
$response = $finvalda->transactions()->sales($query->toFilter());
$response = $finvalda->transactions()->salesDetail($query->toFilter());

// Query methods
$query = TransactionQuery::create()
    ->journal('PARD')              // Filter by journal code
    ->operationNumber(123)         // Filter by operation number
    ->series('AA')                 // Filter by document series
    ->orderNumber('SF-001')        // Filter by order/document number
    ->journalGroup('SALES_GRP')    // Filter by journal group
    ->dateFrom('2024-01-01')       // Operation date from
    ->dateTo('2024-12-31')         // Operation date to
    ->dateRange('2024-01-01', '2024-12-31')  // Both dates at once
    ->modifiedSince('2024-06-01'); // Only modified since
```

### Operation Query

```php
use Finvalda\Query\OperationQuery;

// Factory methods for common operation types
$query = OperationQuery::sales()
    ->journal('PARD')
    ->dateRange('2024-01-01', '2024-12-31')
    ->client('CLI001');

// Use with operations resource
$response = $finvalda->operations()->query($query->opClass(), $query->build());

// All factory methods
$query = OperationQuery::sales();
$query = OperationQuery::salesDetail();
$query = OperationQuery::purchases();
$query = OperationQuery::purchasesDetail();
$query = OperationQuery::inflows();
$query = OperationQuery::inflowsDetail();
$query = OperationQuery::disbursement();
$query = OperationQuery::disbursementDetail();
$query = OperationQuery::internalTransactions();
$query = OperationQuery::internalTransactionsDetail();
$query = OperationQuery::forClass(OpClass::SalesReturns);

// Query methods
$query = OperationQuery::sales()
    ->journal('PARD')
    ->number(123)
    ->series('AA')
    ->client('CLI001')
    ->warehouse('WH01')
    ->product('PRD001')
    ->dateFrom('2024-01-01')
    ->dateTo('2024-12-31')
    ->modifiedSince('2024-06-01')
    ->journalGroup('SALES_GRP')
    ->object1('DEPT01')
    ->object2('PROJ01');
```

## Validation

Validate data before sending to the API to catch errors early:

```php
use Finvalda\Validation\Validator;
use Finvalda\Validation\Rules\Required;
use Finvalda\Validation\Rules\StringLength;
use Finvalda\Validation\Rules\NumericRange;
use Finvalda\Validation\Rules\DateFormat;
use Finvalda\Exceptions\ValidationException;

// Define validation rules
$validator = new Validator([
    'sKodas' => [new Required(), StringLength::max(50)],
    'sPavadinimas' => [new Required(), StringLength::max(200)],
    'dKaina' => [NumericRange::positive()],
    'tData' => [DateFormat::ymd()],
]);

// Validate data
$result = $validator->validate([
    'sKodas' => 'PRD001',
    'sPavadinimas' => 'Product Name',
    'dKaina' => 19.99,
    'tData' => '2024-01-15',
]);

if ($result->fails()) {
    foreach ($result->errors as $field => $errors) {
        echo "{$field}: " . implode(', ', $errors) . "\n";
    }
}

// Or validate and throw exception
try {
    $validator->validateOrFail($data);
} catch (ValidationException $e) {
    $errors = $e->getErrors();
    $allMessages = $e->getAllErrors();
}

// Quick validation
$result = Validator::check($data, [
    'sKodas' => [new Required()],
    'sPavadinimas' => [new Required(), StringLength::between(3, 200)],
]);

// Available rules
new Required();                          // Field is required
new Required('Custom message');          // With custom message
StringLength::max(50);                   // Max 50 characters
StringLength::min(3);                    // Min 3 characters
StringLength::between(3, 50);            // Between 3 and 50
StringLength::exact(10);                 // Exactly 10 characters
NumericRange::positive();                // >= 0
NumericRange::positiveNonZero();         // > 0
NumericRange::min(10);                   // >= 10
NumericRange::max(100);                  // <= 100
NumericRange::between(10, 100);          // Between 10 and 100
DateFormat::ymd();                       // Y-m-d format
DateFormat::datetime();                  // Y-m-d H:i:s format
new DateFormat('d/m/Y');                 // Custom format
```

## Resources

All read methods return a `Response` object:

```php
$response = $finvalda->clients()->list();

$response->successful();  // bool - whether the request succeeded
$response->failed();      // bool - whether the request failed
$response->data;          // array - the response data
$response->error;         // ?string - error message if failed
$response->raw;           // array - full raw response
```

All write methods return an `OperationResult` object:

```php
$result = $finvalda->clients()->create($data);

$result->success;     // bool
$result->series;      // ?string
$result->document;    // ?string
$result->journal;     // ?string
$result->number;      // ?int
$result->error;       // ?string
$result->errorCode;   // ?int
```

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
use Finvalda\Enums\ClientTypeId;

// List / find / collect
$response = $finvalda->clients()->list();
$response = $finvalda->clients()->list(modifiedSince: '2024-01-01');
$response = $finvalda->clients()->get('CLIENT001');
$client = $finvalda->clients()->find('CLIENT001');      // Returns typed Client DTO
$clients = $finvalda->clients()->collect();             // Returns ClientCollection

// All clients (with optional date filters)
$response = $finvalda->clients()->all();
$response = $finvalda->clients()->all(modifiedSince: '2024-01-01');

// Client email
$response = $finvalda->clients()->email('CLIENT001');

// Client types and tags (use enum for type-safety)
$response = $finvalda->clients()->typesAndTags(ClientTypeId::Type);   // Client types
$response = $finvalda->clients()->typesAndTags(ClientTypeId::Tag1);   // Tag 1 options
$response = $finvalda->clients()->typesAndTags(ClientTypeId::Tag2);   // Tag 2 options
$response = $finvalda->clients()->typesAndTags(ClientTypeId::Tag3);   // Tag 3 options
$response = $finvalda->clients()->typesAndTags(22);                   // Also accepts int

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

// Settlements
$response = $finvalda->clients()->settlements(series: 'SER', document: 'DOC001');
$response = $finvalda->clients()->settlements(journal: 'PARD', number: 123);
$response = $finvalda->clients()->settlementsDetailed(series: 'SER', document: 'DOC001');
$response = $finvalda->clients()->settlementsFromDate(series: 'SER', modifiedSince: '2024-01-01');

// CRUD operations
$result = $finvalda->clients()->create([
    'sKodas' => 'NEW001',
    'sPavadinimas' => 'New Client Ltd',
    'sDebtSask' => '2410',
    'sKredSask' => '5001',
]);

$result = $finvalda->clients()->update([
    'sKodas' => 'NEW001',
    'sPavadinimas' => 'Updated Client Name',
]);

$result = $finvalda->clients()->delete('CLIENT001');

// Invoices related to a customer
$response = $finvalda->clients()->invoicesRelatedToCustomer('CLIENT001', debtType: 0);
```

### Products

```php
use Finvalda\Enums\ProductTypeId;

// List / find / collect
$response = $finvalda->products()->list();
$response = $finvalda->products()->get('PROD001');
$product = $finvalda->products()->find('PROD001');      // Returns typed Product DTO
$products = $finvalda->products()->collect();           // Returns ProductCollection

// Extended list with filters
$response = $finvalda->products()->listExtended(
    type: 'ELECTRONICS',
    supplier1: 'SUPP01',
    modifiedSince: '2024-01-01',
);

// All products
$response = $finvalda->products()->all(modifiedSince: '2024-01-01');

// Product image
$response = $finvalda->products()->image('PROD001');

// Products in warehouse
$response = $finvalda->products()->inWarehouse('WH01', modifiedSince: '2024-01-01');
$response = $finvalda->products()->inWarehouseOrdered('WH01', order: 1);

// Types and tags (use enum for type-safety)
$response = $finvalda->products()->typesAndTags(ProductTypeId::Type);  // Product types
$response = $finvalda->products()->typesAndTags(ProductTypeId::Tag1);  // Tag 1 options
$response = $finvalda->products()->typesAndTags(ProductTypeId::Tag2);  // Tag 2-6...
$response = $finvalda->products()->typeGroups();
$response = $finvalda->products()->typeGroupComposition('GRP01');
$response = $finvalda->products()->byType('ELECTRONICS');

// Product history
$response = $finvalda->products()->history('PROD001', dateFrom: '2024-01-01');

// Sold products per period
$response = $finvalda->products()->soldPerPeriod(
    productCode: 'PROD001',
    warehouseCode: 'WH01',
    dateFrom: '2024-01-01',
    dateTo: '2024-12-31',
);

// CRUD operations
$result = $finvalda->products()->create([
    'sKodas' => 'NEWPROD',
    'sPavadinimas' => 'New Product',
    'sRysysSuSask' => '2414',
    'sMatavimoVnt' => 'vnt',
]);

$result = $finvalda->products()->update([
    'sKodas' => 'PROD001',
    'sPavadinimas' => 'Updated Product Name',
]);

$result = $finvalda->products()->editProperties('PROD001', [
    'dKaina1' => 19.99,
    'sRusis' => 'ELECTRONICS',
]);

$result = $finvalda->products()->delete('PROD001');
```

### Services

```php
use Finvalda\Enums\ServiceTypeId;

// List / find / collect
$response = $finvalda->services()->list();
$response = $finvalda->services()->get('SVC001');
$service = $finvalda->services()->find('SVC001');       // Returns typed Service DTO
$services = $finvalda->services()->collect();           // Returns ServiceCollection

// All services
$response = $finvalda->services()->all(modifiedSince: '2024-01-01');

// Types and tags (use enum for type-safety)
$response = $finvalda->services()->typesAndTags(ServiceTypeId::Type);  // Service types
$response = $finvalda->services()->typesAndTags(ServiceTypeId::Tag1);  // Tag 1 options
$response = $finvalda->services()->byType('CONSULTING');

// CRUD operations
$result = $finvalda->services()->create([
    'sKodas' => 'NEWSVC',
    'sPavadinimas' => 'New Service',
    'sRysysSuSask' => '5001',
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

```php
use Finvalda\Filters\TransactionFilter;
use Finvalda\Filters\PaymentFilter;
use Finvalda\Query\TransactionQuery;

// Using filter DTO
$filter = new TransactionFilter(
    dateFrom: '2024-01-01',
    dateTo: '2024-12-31',
    journalGroup: 'PARD_GRP',
);

// Or using fluent query builder
$filter = TransactionQuery::create()
    ->dateRange('2024-01-01', '2024-12-31')
    ->journalGroup('PARD_GRP')
    ->toFilter();

// Sales
$response = $finvalda->transactions()->sales($filter);
$response = $finvalda->transactions()->salesDetail($filter);
$response = $finvalda->transactions()->salesDetailWithPrimeCost($filter);

// Sale Reservations
$response = $finvalda->transactions()->saleReservations($filter);
$response = $finvalda->transactions()->saleReservationsDetail($filter);

// Sales Returns
$response = $finvalda->transactions()->salesReturns($filter);
$response = $finvalda->transactions()->salesReturnsDetail($filter);

// Purchases
$response = $finvalda->transactions()->purchases($filter);
$response = $finvalda->transactions()->purchasesDetail($filter);
$response = $finvalda->transactions()->purchasesExtendedDetail($filter);

// Purchase Orders & Returns
$response = $finvalda->transactions()->purchaseOrders($filter);
$response = $finvalda->transactions()->purchaseOrdersDetail($filter);
$response = $finvalda->transactions()->purchaseReturns($filter);
$response = $finvalda->transactions()->purchaseReturnsDetail($filter);

// Inflows with payment reference
$response = $finvalda->transactions()->inflowsDetail(
    filter: $filter,
    paymentFilter: new PaymentFilter(
        payedForDocSeries: 'AA',
        payedForDocOrderNumber: 'SF-001',
    ),
);

// Advance Payments
$response = $finvalda->transactions()->advancedPaymentsDetail(
    filter: $filter,
    client: 'CLIENT001',
    offsetStatus: 0,
);

// Disbursements & Clearing
$response = $finvalda->transactions()->disbursementsDetail($filter);
$response = $finvalda->transactions()->clearingOffsDetail($filter);

// OMM (Order Management Module)
$response = $finvalda->transactions()->ommSales($filter);
$response = $finvalda->transactions()->ommSalesDetail($filter);
$response = $finvalda->transactions()->ommPurchases($filter);

// Fixed Assets & Currency
$response = $finvalda->transactions()->depreciationOfFixedAssets(year: 2024, month: 6);
$response = $finvalda->transactions()->currencyDebtRecount($filter);

// Low Value Inventory
$response = $finvalda->transactions()->lowValueInventory();
```

### Operations (Create, Update, Delete)

Operations require a `$parameter` argument which is server-configured. See [Server-Configured Parameters](#server-configured-parameters).

```php
use Finvalda\Enums\OperationClass;
use Finvalda\Enums\DeleteOperationClass;
use Finvalda\Enums\UpdateOperationClass;
use Finvalda\Enums\OpClass;
use Finvalda\Query\OperationQuery;

$parameter = 'STANDARD'; // Server-configured

// Create operations (prefer fluent builders - see above)
$result = $finvalda->operations()->create(OperationClass::Sale, $data, $parameter);
$result = $finvalda->operations()->create(OperationClass::Purchase, $data, $parameter);
$result = $finvalda->operations()->create(OperationClass::InternalTransfer, $data, $parameter);

// Delete an operation
$result = $finvalda->operations()->delete(
    DeleteOperationClass::Sale,
    journal: 'PARD',
    number: 123,
    parameter: $parameter,
);

// Update an operation
$result = $finvalda->operations()->update(UpdateOperationClass::Sale, [
    'sZurnalas' => 'PARD',
    'nNumeris' => 123,
    'PardDokHeadEil' => ['sPastaba' => 'Updated comment'],
], $parameter);

// Read operations with query builder
$query = OperationQuery::sales()
    ->dateRange('2024-01-01', '2024-12-31')
    ->client('CLIENT001');

$response = $finvalda->operations()->query($query->opClass(), $query->build());

// Or with arrays
$response = $finvalda->operations()->get(OpClass::Sales, [
    'OpDateFrom' => '2024-01-01',
    'OpDateTill' => '2024-12-31',
]);

// Lock / unlock operations
$finvalda->operations()->lock('PARD', 123);
$finvalda->operations()->unlock('PARD', 123);
$response = $finvalda->operations()->isLocked('PARD', 123);

// Change journal / copy
$result = $finvalda->operations()->changeJournal([
    'sZurnalas' => 'PARD',
    'nNumeris' => 123,
    'sNaujasZurnalas' => 'PARD2',
]);

$result = $finvalda->operations()->copy([
    'sZurnalas' => 'PARD',
    'nNumeris' => 123,
]);
```

### Order Management (UVM)

```php
$response = $finvalda->orderManagement()->salesReservationStatus('PARD', 123);

$response = $finvalda->orderManagement()->completedReservations(
    journalGroup: 'PARD_GRP',
    dateFrom: '2024-01-01',
    dateTo: '2024-12-31',
);
$response = $finvalda->orderManagement()->pendingReservations();
$response = $finvalda->orderManagement()->cancelledReservations();
$response = $finvalda->orderManagement()->orderedProducts(dateFrom: '2024-01-01');
```

### Pricing & Discounts

```php
// Combined client + item prices
$response = $finvalda->pricing()->clientItemPrices(clientCode: 'CLI001', itemCode: 'PROD001');
$response = $finvalda->pricing()->clientTypeItemPrices(clientTypeCode: 'VIP', itemCode: 'PROD001');
$response = $finvalda->pricing()->clientItemTypePrices(clientCode: 'CLI001', itemTypeCode: 'ELECTRONICS');

// Product discounts and additional prices
$response = $finvalda->pricing()->clientProductDiscounts('CLI001');
$response = $finvalda->pricing()->clientProductAdditionalPrices('CLI001');
$response = $finvalda->pricing()->clientProductTypeDiscounts('CLI001');

// Service pricing
$response = $finvalda->pricing()->clientServiceDiscounts('CLI001');
$response = $finvalda->pricing()->clientServiceAdditionalPrices('CLI001');

// Client type pricing
$response = $finvalda->pricing()->clientTypeProductDiscounts('VIP');
$response = $finvalda->pricing()->clientTypeServiceDiscounts('VIP');

// Recommended price calculation
$response = $finvalda->pricing()->recommendedPrice([
    'invoiceType' => 0,
    'invoiceDate' => ['year' => 2024, 'month' => 6, 'day' => 15],
    'itemType' => 1,
    'itemCode' => 'PROD001',
    'itemAmount' => 10,
    'warehouseCode' => 'WH01',
    'clientCode' => 'CLI001',
]);
```

### Documents

```php
use Finvalda\Enums\DocumentEntityType;

// Upload
$result = $finvalda->documents()->uploadFile('invoice.pdf', '/path/to/invoice.pdf');
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
$response = $finvalda->reports()->makeInvoice('param_string');
$response = $finvalda->reports()->makeReport('param_string');
$response = $finvalda->reports()->autoReports();
$response = $finvalda->reports()->autoReport('report_filename.pdf');
```

### Descriptions (Universal Query)

```php
use Finvalda\Enums\DescriptionType;

$response = $finvalda->descriptions()->get(DescriptionType::Products, [
    'Codes' => ['PROD001', 'PROD002'],
], page: 1, limit: 50);

// Convenience methods
$response = $finvalda->descriptions()->stockOnDate('2024-06-15', ['Warehouse' => 'WH01']);
$response = $finvalda->descriptions()->products(['Type' => 'ELECTRONICS']);
$response = $finvalda->descriptions()->clients(['Email' => 'client@example.com']);
$response = $finvalda->descriptions()->services();
$response = $finvalda->descriptions()->currentStock(['Warehouse' => 'WH01']);
$response = $finvalda->descriptions()->fixedAssets();
$response = $finvalda->descriptions()->barCodes(['Codes' => ['PROD001']]);
$response = $finvalda->descriptions()->prices(['Client' => 'CLI001']);
$response = $finvalda->descriptions()->currencyRates('2024-01-01', '2024-12-31', ['USD', 'GBP']);
```

### Reference Data

```php
$response = $finvalda->references()->measurementUnits();
$response = $finvalda->references()->warehouses();
$response = $finvalda->references()->taxes();
$response = $finvalda->references()->paymentTerms();
$response = $finvalda->references()->user();

// Create reference entities
$result = $finvalda->references()->createBank(['sKodas' => 'BNK01', 'sPavadinimas' => 'My Bank']);
$result = $finvalda->references()->createWarehouse(['sKodas' => 'WH03', 'sPavadinimas' => 'Warehouse 3']);
$result = $finvalda->references()->createPaymentTerm(['sKodas' => 'NET30', 'sPavadinimas' => 'Net 30']);
$result = $finvalda->references()->createClientType(['sKodas' => 'VIP', 'sPavadinimas' => 'VIP Clients']);
$result = $finvalda->references()->createProductType(['sKodas' => 'ELEC', 'sPavadinimas' => 'Electronics']);
```

### User Permissions

```php
$response = $finvalda->permissions()->warehouses();
$response = $finvalda->permissions()->clients();
$response = $finvalda->permissions()->operationTypes();
$response = $finvalda->permissions()->operationJournals();
```

## Pagination

For large datasets, use lazy pagination with the `Cursor` class:

```php
use Finvalda\Pagination\Cursor;
use Finvalda\Pagination\LazyCollection;

// Create a cursor for clients
$cursor = new Cursor(
    fetcher: fn($modifiedSince, $createdSince) =>
        $finvalda->clients()->all($modifiedSince, $createdSince)->data,
    dateExtractor: fn($item) => isset($item['tKoregavimoData'])
        ? new \DateTime($item['tKoregavimoData'])
        : null,
);

// Iterate lazily (memory efficient)
foreach ($cursor->modifiedSince('2024-01-01')->getIterator() as $clientData) {
    echo $clientData['sPavadinimas'] . "\n";
}

// Take first N items
$first100 = $cursor->take(100);

// Get all as array
$allClients = $cursor->all();

// LazyCollection for generator-based iteration
$lazy = LazyCollection::make($finvalda->clients()->all()->data);

$filtered = $lazy
    ->filter(fn($c) => ($c['dSkola'] ?? 0) > 0)
    ->map(fn($c) => $c['sPavadinimas'])
    ->take(10)
    ->all();
```

## Error Handling

```php
use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Exceptions\AccessDeniedException;
use Finvalda\Exceptions\ValidationException;
use Finvalda\Exceptions\NotFoundException;
use Finvalda\Exceptions\NetworkException;
use Finvalda\Exceptions\ServerException;
use Finvalda\Exceptions\RetryExhaustedException;

try {
    $client = $finvalda->clients()->find('CLI001');
} catch (NotFoundException $e) {
    echo "Client not found";
} catch (AccessDeniedException $e) {
    echo "Access denied: {$e->getMessage()}";
} catch (NetworkException $e) {
    echo "Network error (connection failed, timeout): {$e->getMessage()}";
} catch (ServerException $e) {
    echo "Server error (5xx): {$e->getMessage()}";
} catch (RetryExhaustedException $e) {
    echo "All {$e->attempts} retry attempts failed: {$e->getMessage()}";
} catch (ValidationException $e) {
    $errors = $e->getErrors();
    $allMessages = $e->getAllErrors();
} catch (FinvaldaException $e) {
    echo "API error: {$e->getMessage()}";
}

// Check response status
$response = $finvalda->clients()->list();

if ($response->failed()) {
    echo "Error: {$response->error}";
}

// Check operation result
$result = $finvalda->clients()->create($data);

if ($result->success) {
    echo "Created: {$result->journal} #{$result->number}";
} else {
    echo "Error #{$result->errorCode}: {$result->error}";
}
```

## Server-Configured Parameters

Finvalda uses server-configured parameters that depend on your installation.

### sParametras (Operations)

Required for operation methods (`create`, `update`, `delete`). Tells the server which journal configuration to use.

```php
$parameter = 'STANDARD'; // Your server-configured value

$result = $finvalda->operations()->create(OperationClass::Sale, $data, $parameter);
$result = $finvalda->sale()->client('CLI001')->addProduct('PRD001', 10, 19.99)->save($parameter);
```

### sFvsImportoParametras (Items)

Optional data field for item methods. Include in data array if required:

```php
$result = $finvalda->clients()->create([
    'sKodas' => 'NEW001',
    'sPavadinimas' => 'New Client Ltd',
    'sFvsImportoParametras' => 'NUOMA', // Server-configured
]);
```

### Troubleshooting Parameter Errors

If you receive an error like:

```json
{
  "nResult": 1036,
  "sError": "Parameter 'NET_DELSPINIGIAI_SUPVM' not found in database!"
}
```

This means the parameter is not configured on your server. Contact your Finvalda administrator for valid parameter values.

## API Versions

This SDK targets **V2 (FvsServicePure)** - the recommended REST interface.

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

## License

MIT
