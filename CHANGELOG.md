# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
