# Finvalda PHP SDK

## Project Overview
PHP SDK/Composer package for the Finvalda (FVS) Lithuanian accounting/ERP software web service API. Targets V2 (FvsServicePure) REST endpoints returning JSON.

## Architecture
- **Entry point**: `Finvalda\Finvalda` — creates an SDK instance with config, provides lazy-loaded resource accessors
- **Resources**: 15 resource classes in `src/Resources/`, each covering a domain (clients, products, operations, etc.)
- **HTTP layer**: `HttpClient` wraps Guzzle, handles auth headers, JSON parsing, error mapping
- **Enums**: Type-safe constants for operation classes, languages, access results, description types
- **Filters**: `TransactionFilter` and `PaymentFilter` DTOs for query construction
- **Laravel**: Service provider with auto-discovery, Facade, publishable config

## Key Patterns
- All read methods return `Finvalda\Responses\Response` with `->data`, `->successful()`, `->error`, `->raw`
- All write methods return `Finvalda\Responses\OperationResult` with `->success`, `->journal`, `->number`, `->error`
- Resources extend `Finvalda\Resources\Resource` base class
- Builders extend `Finvalda\Builders\OperationBuilder` base class
- HttpClient is injectable (constructor accepts `?ClientInterface`)
- Date parameters accept `DateTimeInterface|string|null` (format: Y-m-d)

## Builders
All 23 `OperationClass` enum cases have corresponding builders accessible via `Finvalda`:
- **Sales**: `sale()`, `salesReservation()`, `salesReturn()` — each supports `->short()` for Trumpas* variants
- **Purchases**: `purchase()`, `purchaseOrder()`, `purchaseReturn()` — each supports `->short()`
- **Transfers & Adjustments**: `internalTransfer()`, `writeOff()`, `capitalization()`, `inventoryCount()`
- **Payments**: `inflow()`, `disbursement()`, `clearing()`
- **Production**: `production()` — three line types: finished goods, raw materials, services
- **Other**: `nonAnalytical()` — general ledger debit/credit entries
- **UVM**: `uvmSalesReservation()`, `uvmCancellation()`, `uvmPurchaseOrder()`

Special build structures: ClearingBuilder (debit/credit lines), ProductionBuilder (3 line types), NonAnalyticalBuilder (accounting entries), UvmCancellationBuilder (cancellation refs), InventoryCountBuilder (flat items with mode wrapper).

## File Structure
```
src/
  Finvalda.php              # Main client — $finvalda->clients(), ->products(), etc.
  FinvaldaConfig.php        # Config DTO (baseUrl, username, password, language, etc.)
  HttpClient.php            # HTTP transport layer (Guzzle, injectable)
  Builders/                 # 18 fluent operation builders (OperationBuilder base + 17 concrete)
  Enums/                    # AccessResult, Language, ItemClass, OperationClass, OpClass, etc.
  Exceptions/               # FinvaldaException, AccessDeniedException, ValidationException
  Filters/                  # TransactionFilter, PaymentFilter DTOs
  Resources/                # 15 resource classes (Stock, Clients, Products, etc.)
  Responses/                # Response, OperationResult
  Laravel/                  # ServiceProvider, Facade
config/
  finvalda.php              # Laravel config (publishable)
docs/                       # API documentation (.doc, .txt, Postman collection)
```

## Available Resources
| Accessor | Class | Purpose |
|---|---|---|
| `->stock()` | Stock | Inventory balances (current, extended, with prices, by group) |
| `->clients()` | Clients | CRUD, accounts, settlements, debt, email |
| `->products()` | Products | CRUD, warehouse queries, history, images, types |
| `->services()` | Services | CRUD, types and tags |
| `->objects()` | Objects | 6 levels of analytical objects CRUD |
| `->transactions()` | Transactions | Read financial details (sales, purchases, inflows, etc.) |
| `->operations()` | Operations | Create/delete/update/query/lock accounting operations |
| `->pricing()` | Pricing | Discounts and prices by client/product/service/type combos |
| `->orderManagement()` | OrderManagement | UVM reservation status, ordered products |
| `->documents()` | Documents | Upload, attach, list, delete documents |
| `->reports()` | Reports | Invoice/report PDF generation |
| `->descriptions()` | Descriptions | Universal query (GetDescriptions) with 27+ types |
| `->references()` | References | Measurement units, warehouses, taxes, payment terms |
| `->permissions()` | Permissions | User permission queries |

## API Field Name Convention
The Finvalda API uses Lithuanian-prefixed field names. Common prefixes:
- `s` = string (sKodas = code, sPavadinimas = name)
- `n` = number (nKiekis = quantity, nNumeris = number)
- `d` = decimal (dSumaV = amount in currency, dKaina1 = price 1)
- `t` = datetime (tData = date, tKoregavimoData = modified date)
- `b` = boolean (bGaliojimas = validity)

## API Documentation Source
- Official Postman docs: https://documenter.getpostman.com/view/7208231/2s8YmRMLvd
- Collection can be fetched via: `https://documenter.getpostman.com/api/collections/7208231/2s8YmRMLvd`
- Local collection: `docs/FvsWebService.postman_collection.json`
- Local .doc converted to text: `docs/FVS_Webservice.txt`

## Running Checks
```bash
vendor/bin/phpstan analyse
vendor/bin/phpunit
```

## Updating the Postman Collection
```bash
bin/sync-postman-collection
```
