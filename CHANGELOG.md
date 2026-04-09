# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.2.0] - 2026-04-09

### Added
- **Finvalda::ping()**: Test connection and credentials with a single call — returns `true` if the server is reachable and credentials are valid
- **Finvalda::getHttpClient()**: Access the underlying `HttpClient` for advanced usage
- **Finvalda::setDebug()** / **getLastDebugInfo()**: Proxy methods for debug mode without reaching into HttpClient

## [2.1.0] - 2026-04-09

### Added
- **ProductLine DTO**: Fluent value object for building product detail lines with full IDE discoverability — `ProductLine::make('CODE', qty)->warehouse()->amount()->vat()->discount()->object()->objects()->intrastat()->weight()->firstMeasurement()->info()->marked()->set()`
- **ServiceLine DTO**: Fluent value object for service detail lines — `ServiceLine::make('CODE', qty)->amount()->vat()->discount()->object()->objects()->vatCode()->info()->marked()->set()`
- **OperationBuilder::product()**: Accepts `ProductLine` DTOs, adds to product lines array
- **OperationBuilder::service()**: Accepts `ServiceLine` DTOs, adds to service lines array
- Sparse object support on line DTOs: `->object(1, 'DEPT01')->object(4, '1234567')` — levels 2,3,5,6 remain unset
- `set()` escape hatch on both DTOs for raw API fields not covered by named methods

### Changed
- **ProductionBuilder::product()** renamed to **finishedProduct()** to avoid conflict with new `OperationBuilder::product(ProductLine)` method

## [2.0.0] - 2026-04-09

### Changed (Breaking)
- **HTTP transport**: All POST write operations now use JSON body instead of form-encoded params, matching the Postman collection's "Json Body" variant
- **GetDescriptions**: Now wraps parameters in `{"readParams":{...}}` envelope and uses lowercase `type` key, matching the documented API format
- **GetOperations (POST)**: Now wraps parameters in `{"opReadParams":{...}}` envelope
- **DeleteItem**: Uses `{"input":{"ItemClassName":"...","Code":"..."}}` JSON body format per Postman spec
- **ChangeJournal**: Now sends flat JSON body (`sJournal`, `nOpNumber`, `sJournalNew`) instead of xmlstring wrapper
- **CopyOperation**: Now sends `{"input":{...}}` JSON body instead of xmlstring wrapper
- **DeleteOperation**: Journal/number now correctly sent inside xmlstring JSON body
- **LockOperation/UnLockOperation**: Switched from form params to JSON body per REST docs
- **IsOperationLocked**: Switched from query params to JSON body per REST docs
- **Products::editProperties()**: Signature changed from `(string $productCode, array $properties)` to `(array $data)` — data must include `Kodas` array and properties to set, wrapped in `Fvs.EditItemProps > Fvs.Prekes`
- **Descriptions::tagsAndTypes()**: Now uses `readParams` wrapper via `get()` method

### Added
- **HttpClient::postOperationJson()**: New method for endpoints that use flat JSON body and return OperationResult (Lock, Unlock, ChangeJournal, CopyOperation, DeleteItem)
- **Debug mode**: `HttpClient::setDebug()` and `getLastDebugInfo()` to capture full request/response cycle for troubleshooting
- **ItemClass::ProductTag1-20**: 20 new enum cases for product tag item classes (Fvs.PrekesPoz1 through Fvs.PrekesPoz20)
- **ItemClass::productTag(int)**: Static helper to get ProductTag case by number
- **References::createProductTag()**: Create product tag values (Fvs.PrekesPoz1-20) via InsertNewItem
- **DescriptionType::OperationStatuses**: New description type for operation status queries
- **DescriptionType::Accounts**: New description type for account queries
- **SaleBuilder**: Added `roundingAmount()`, `exportToIvaz()`, `locked()`, `employee()` methods
- **PurchaseBuilder**: Added `roundingAmount()`, `exportToIvaz()`, `locked()`, `employee()` methods
- **InternalTransferBuilder**: Added `exportToIvaz()`, `marked()`, `employee()` methods
- **InflowBuilder**: Added `locked()`, `employee()` methods
- **DisbursementBuilder**: Added `locked()`, `employee()` methods
- **Operations::unlock()**: Added optional `$newJournal` parameter (maps to `sZurnalasNaujas`)
- Synced Postman collection to latest version (April 2026)

### Fixed
- **GetDescriptions**: Was sending flat params without `readParams` wrapper — API requires the envelope
- **GetOperations POST**: Was sending flat params without `opReadParams` wrapper
- **Descriptions::tagsAndTypes()**: Was bypassing `get()` method, sending wrong format without `readParams` wrapper
- **EditItemProps**: Was sending extra `ItemClassName`/`sKodas` params and missing `Fvs.EditItemProps` wrapper
- **DeleteOperation**: Was sending journal/number as bare params instead of inside xmlstring
- **Clients::invoicesRelatedToCustomer()**: Restored to `post()` with query params matching Postman spec
- Removed `Content-Type: application/json` from default Guzzle headers — Guzzle's `json` option sets it automatically

## [1.1.1] - 2026-04-08

### Fixed
- Fix `parseOperationResult` ignoring `AccessResult::Fail` when `nResult` is 0

## [1.1.0] - 2026-04-03

### Added
- **Sales Reservation Builder**: `salesReservation()` for PardRezDok operations
- **Purchase Order Builder**: `purchaseOrder()` for PirkUzsDok operations
- **Write-Off Builder**: `writeOff()` for NurasymasDok inventory disposal operations
- **Capitalization Builder**: `capitalization()` for PajamavimasDok inventory receiving operations
- **Clearing Builder**: `clearing()` for UzskaitaDok set-off operations with debit/credit lines
- **Production Builder**: `production()` for GamybaDok operations with finished goods, raw materials, and services
- **Non-Analytical Builder**: `nonAnalytical()` for KtNeanalitDok general ledger entries
- **Inventory Count Builder**: `inventoryCount()` for Inventorizacija operations with mode support
- **UVM Sales Reservation Builder**: `uvmSalesReservation()` for UVMPardRezDok workshop/service orders
- **UVM Purchase Order Builder**: `uvmPurchaseOrder()` for UVMPirkUzsDok operations
- **UVM Cancellation Builder**: `uvmCancellation()` for UVMAnulDok operations
- **Short operation support**: `short()` method on sale, purchase, and return builders to use simplified Trumpas* variants
- Added `series()`, `documentType()`, `fulfillmentDate()` methods to sale, purchase, and return builders
- Comprehensive builder test suite (46 tests covering all builders, build output, short toggles)

## [1.0.0] - Unreleased

### Added
- Initial release
- Full coverage of Finvalda V2 (FvsServicePure) REST API
- 15 resource classes: Stock, Clients, Products, Services, Objects, Transactions, Operations, Pricing, OrderManagement, Documents, Reports, Descriptions, References, Permissions
- 130+ API endpoint implementations
- Laravel service provider with auto-discovery, Facade, and publishable config
- TransactionFilter and PaymentFilter DTOs for query construction
- Injectable HttpClient for testing
- PHPStan level 6 analysis
- Comprehensive PHPDoc on all public methods

### Developer Experience Improvements
- **Typed DTOs**: `Client`, `Product`, `Service`, `StockBalance`, `AnalyticalObject` data transfer objects with full IDE autocomplete
- **Collections**: `ClientCollection`, `ProductCollection`, `ServiceCollection` with filtering methods (`findByCode()`, `whereType()`, `withDebt()`)
- **Fluent Operation Builders**: `sale()`, `purchase()`, `internalTransfer()`, `salesReturn()`, `purchaseReturn()`, `inflow()`, `disbursement()` for readable operation creation
- **Query Builders**: `TransactionQuery` and `OperationQuery` for fluent API filtering
- **Retry Logic**: Configurable `RetryPolicy` with exponential backoff for transient failures
- **PSR-3 Logging**: `setLogger()` method for request/response debugging
- **Cursor Pagination**: `Cursor` and `LazyCollection` for memory-efficient iteration over large datasets
- **Validation**: `Validator` with rules (`Required`, `StringLength`, `NumericRange`, `DateFormat`)
- **Exception Hierarchy**: `NetworkException`, `NotFoundException`, `ConflictException`, `ServerException`, `OperationFailedException`, `RetryExhaustedException`
- **Enum Constants**: `ClientTypeId`, `ProductTypeId`, `ServiceTypeId`, `DebtType`, `OffsetStatus` for magic number elimination
