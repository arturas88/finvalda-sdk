# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
