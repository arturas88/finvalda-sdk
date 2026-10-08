# Upgrading

## From 3.x to 4.0

v4 makes the SDK send only what the Finvalda WS spec defines. The server **silently
ignores** unknown fields and unknown query parameters, so much of what v3 sent never had
an effect: due dates were never set, price filters never filtered, payment lines never
arrived. Most of the edits below make your code do what it already claimed to do.

Work through the sections in order. **Section 1 matters most:** those calls change
behaviour without a PHP error, unless v4 catches them for you (it does where it can).
The full list is in the [CHANGELOG](CHANGELOG.md).

### 1. Calls that compile but would mean something else

v4 **retires** these names rather than reusing them: calling one throws a
`LogicException` that names the replacement. Search for each one.

**Payments: `forDocument()` → `payDocument()`**

```php
// v3: (document, journal, number, amount); none of these fields are in the spec
$finvalda->inflow()->client('C1')->forDocument('SF-123', 'PARD', 42, 500.00);

// v4: (series, document, amount); sets nTipas to PaymentType::Documents
$finvalda->inflow()->client('C1')->payDocument('SF', '123', 500.00);
```

A payment now needs its type (the spec's required `nTipas`). `payDocument()` sets it;
otherwise call `type()`:

```php
$finvalda->inflow()->client('C1')->type(PaymentType::Advance)->addLine(100.00);
```

**Documents: `attach()` / `attached()` → `attachTo()` / `attachedTo()`**

```php
// v3
$documents->attach(DocumentEntityType::Sale, '', 'a.pdf', 'PARD', 42);
$documents->attached(DocumentEntityType::Sale, '', 'PARD', 42);

// v4: an operation is id1 = journal, id2 = number
$documents->attachTo(DocumentEntityType::Sale, 'PARD', 'a.pdf', 42);
$documents->attachedTo(DocumentEntityType::Sale, 'PARD', 42);
```

**Permissions: `get(int)` → `forUser(?string)`**

```php
// v3: get($permissionClass); the WS has no class parameter
$finvalda->permissions()->get(Permissions::WAREHOUSES);

// v4: everything for one Finvalda user, or one class as an array
$finvalda->permissions()->forUser('S5');                 // Response
$finvalda->permissions()->warehouses('S5');              // list<array{id1, id2}>
$finvalda->permissions()->entities(Permissions::WAREHOUSES, 'S5');
```

**Arguments the server never honoured now throw instead of being dropped**

```php
// v3: returned every client's prices; the codes were ignored
$finvalda->pricing()->clientItemPrices('CLI001', 'PRD001');

// v4: no arguments, and it is the whole matrix (heavy on the server). Prefer the
// per-client method, which does filter:
$finvalda->pricing()->clientProductDiscounts('CLI001');

// v3: date arguments were never applied
$finvalda->stock()->balancesByGroup('P1', 'G1', '2024-01-01');
// v4
$finvalda->stock()->balancesByGroup('P1', 'G1');
```

The other three combined price methods now take `(modifiedSince, createdSince)`. An old
call that passes codes there fails the date check.

**A sale line with a price but no amount throws**

The server books such a line at **0**; it takes the amount from `dSumaV` only. If v3 code
did this, existing documents may have zero-amount lines.

```php
// v3: booked at 0
ProductLine::make('P1', 2)->price(10.00);
$builder->addProduct('P1', 2, price: 10.00);

// v4: send the net amount (after discount); add VAT yourself if the document needs it
ProductLine::make('P1', 2)->price(10.00)->amount(20.00)->vat(percent: 21, amount: 4.20);
$builder->addProduct('P1', 2, amount: 20.00, price: 10.00);
```

A zero-amount line is still allowed, e.g. `ServiceLine::make('S1', 1)->amount(0)` as a
placeholder that is priced later.

**Discount next to an amount is not applied twice** (verified on a live server for both
a purchase line and a sales line): `amount(100)` with `discount(percent: 10)` is booked at
100, with the discount stored as 0. Keep sending the net amount after discount. The
percentage is informational only and is not saved.

### 2. Behaviour that is now correct, so check that you want it

- **`dueDate()`** now sets `tMokejimoData`. v3 wrote a field that does not exist, so no
  due date was ever set. A due date before the document date now throws.
  `purchaseUpdate()->dueDate()` corrects it on an existing purchase without touching
  the lines.
- **`warehouse()`** on a sale or purchase now fills `sSandelis` on each product line that
  has none. v3 wrote a header field the spec does not have. A line's own warehouse wins.
- **Disbursements** use the class `IsmDok`; v3's `IsmokasDok` is not in the spec. Stored
  `OperationClass` values of `'IsmokasDok'` no longer resolve.
- **Inflow/disbursement lines** are now nested inside the header, so the server receives
  them.
- **`OrderManagement`** date filters (`tNuo`/`tIki`) now apply; v3's names were ignored.

### 3. Failures throw instead of looking like "no data"

```php
// v3: a failed request returned an empty collection, so a "delete local records
// missing from Finvalda" sync could wipe everything
$clients = $finvalda->clients()->collect();

// v4: FinvaldaException on a failed request; NotFoundException for an unknown code
try {
    $client = $finvalda->clients()->find($code);
} catch (NotFoundException) {
    // it really does not exist
} catch (FinvaldaException $e) {
    // the request failed: do not treat it as "not there"
}
```

These also throw now:
- `Stock::purchaseOpFor()` on a failed request. `null` still means "no purchase history".
  `assertNotSold()` reports the failure as a `ConflictException`, as before.
- `ping()` on a wrong base URL (404), an `AccessResult: Fail`, or a non-Finvalda answer.
  It is still `false` for a network failure, a 5xx, or rejected credentials.

### 4. Removed methods and classes

Calling a removed builder setter throws a `LogicException` that names the field it
wrote and what to do instead. `method_exists()` stays `false`. Delete the call: the
server ignored the field.

| Removed | Instead |
|---|---|
| `paymentDays()` | `dueDate()` |
| `vatIncluded()` | send net amounts and `vat(percent:, amount:)` |
| `supplierInvoice()` | `documentNumber()` |
| `isAdvance()`, `priceType()`, `responsiblePerson()`, `supplierInvoiceDate()`, `originalDocument()`, `originalDocumentNumber()`, `reason()` | delete the call (no spec field) |
| `operationType()`, `bankAccount()`, `cashRegister()` | the sParametras profile decides |
| payment `amount()` | `addLine()` / `payDocument()` amounts |
| `client()`, `currency()`, `description()`, `documentNumber()`, `warehouse()`, `object1-6()` on builders whose envelope lacks the field | delete, or set objects on the lines; internal transfers use `fromWarehouse()`/`toWarehouse()` |
| `series()` on a full (non-short) purchase | delete (`series('')` is a no-op) |
| `price()` on a purchase line | `amount()` |

Removed classes: `Finvalda\Validation\*`, `Pagination\Cursor`, `Pagination\LazyCollection`
(the API has no pagination), `Query\TransactionQuery` (use `TransactionFilter`),
`Data\StockBalance`, `Data\AnalyticalObject`, `Exceptions\RetryExhaustedException`,
`Debug\LastExchange`, `RetryPolicy::aggressive()`.

### 5. Debugging and raw calls

```php
// v3
$finvalda->setDebug(true);
$info = $finvalda->getLastDebugInfo();

// v4: both still work as deprecated shims; move to recording
$finvalda->record(1);
$info = $finvalda->lastRecording()?->toArray();
// ['request' => [method, url, headers, body],
//  'response' => [status_code, headers, body, duration_ms, error],
//  'attempt' => 1, 'request_id' => '…']
```

For an endpoint the SDK has no method for, call it through the HTTP client:

```php
$finvalda->getHttpClient()->get('GetPrekesIstorija', ['sPreKod' => 'P1']);    // Response
$finvalda->getHttpClient()->getRaw('GetPrekesIstorija', ['sPreKod' => 'P1']); // string
```

### 6. Dates

Every SDK date parameter takes a `DateTimeInterface`, a `'Y-m-d'` string, or a
`'Y-m-d H:i[:s]'` string (the time is sent as given). Anything else, e.g. `'31.01.2024'`
or `'2024/01/31'`, throws `InvalidArgumentException`. Raw arrays passed to
`Operations::query()` or `Descriptions::get(readParams:)` are not checked.

### 7. Transport, exceptions and config

- **Constructors you call directly are unchanged:** `OperationResult`, `Response`,
  `FinvaldaConfig` and `Exchange` keep every parameter name, meaning and position, so
  named and positional calls still work. The only additions, `Exchange::$requestId` and
  `FinvaldaConfig::$httpOptions`, are last and optional. The one constructor that changed
  is `ServerException` (see below).

- **Writes are never retried.** v3 could retry `InsertNewOperation` after a timeout and
  post a document twice. If your code retries SDK writes itself, look the document up
  before you send it again.
- **`RetryExhaustedException` is gone.** You get the real exception
  (`NetworkException`, `ServerException`, `HttpException`), so catch those.
- **4xx errors raise `HttpException`** (code = HTTP status, `->response`).
  `ServerException` extends it, and its constructor is now `(string $message,
  ?ResponseInterface $response)`, which matters only if you construct it, e.g. in tests.
  `getPrevious()` no longer holds the Guzzle exception.
- **Missing countries:** `->throw()` raises `MissingCountryException` (`->countryCode`)
  for `Country 'XX' not found!`. Without `throw()`, use `$result->missingCountryCode()`.
  Countries are added in Finvalda by hand; Greece is `GR`.
- **Laravel:** the client is `scoped()`, so each queue job or Octane request gets a fresh
  one. Call `record()`, `setLogger()` and `withCompany()` where you use the client, not
  once at boot.
- **Config:**
  - `baseUrl` and `timeout` win over an injected Guzzle client's `base_uri`/`timeout`.
    Put TLS, proxy and connect timeout in `http_options` instead.
  - An unknown `language` throws.
  - An empty `FINVALDA_COMPANY_ID=` means "not set".
- **Logs** (only if you parse them):
  - `params` holds query parameters only;
  - `has_body` is gone;
  - each record has a `request_id`.
- **Requirements:** `ext-mbstring`, `guzzlehttp/guzzle` ^7.8 (PHP ^8.3 is unchanged).
