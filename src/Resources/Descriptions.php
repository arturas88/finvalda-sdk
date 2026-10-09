<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
use Finvalda\Enums\DescriptionType;
use Finvalda\Responses\Response;

/**
 * Universal query endpoint (GetDescriptions) with convenience methods for common data types.
 *
 * Filters are sent nested under the type's filter key per API docs, e.g.
 * `{ readParams: { type: "StockOnDate", StockOnDate: { Date: "..." }, columns: [...] } }`.
 */
final class Descriptions extends Resource
{
    /**
     * Query descriptions. Calls GetDescriptions.
     *
     * @param  DescriptionType  $type  The data type to query
     * @param  array<string, mixed>  $filters  Filter parameters, placed under the type's filter key
     * @param  int|null  $page  Page number for pagination (1-based)
     * @param  int|null  $limit  Number of records per page
     * @param  list<string>|null  $columns  Specific columns to return
     * @param  array<string, mixed>  $readParams  Extra readParams keys, merged last — for
     *                                             types that take more than one filter object
     *                                             (Address takes Clients and Address)
     */
    public function get(
        DescriptionType $type,
        array $filters = [],
        ?int $page = null,
        ?int $limit = null,
        ?array $columns = null,
        array $readParams = [],
    ): Response {
        $params = ['type' => $type->value];

        if ($page !== null) {
            $params['page'] = $page;
        }

        if ($limit !== null) {
            $params['limit'] = $limit;
        }

        $filterKey = $type->filterKey();
        if ($filterKey !== null && $filters !== []) {
            $params[$filterKey] = $filters;
        }

        if ($columns !== null) {
            $params['columns'] = $columns;
        }

        return $this->http->postJson('GetDescriptions', [
            'readParams' => array_merge($params, $readParams),
        ]);
    }

    /**
     * Get stock quantities as of a specific date.
     *
     * @param  array<string, mixed>  $filters  Extra keys for the StockOnDate filter (Code, Warehouse, etc.)
     */
    public function stockOnDate(DateTimeInterface|string $date, array $filters = []): Response
    {
        return $this->get(DescriptionType::StockOnDate, array_merge(['Date' => $this->formatDate($date)], $filters));
    }

    /**
     * Get address cards. The Address type takes two filter objects.
     *
     * @param  array<string, mixed>  $clients  Clients filter (Codes, CompanyCode, VatCode)
     * @param  array<string, mixed>  $addresses  Address filter (Codes, Tag1..Tag5)
     * @param  list<string>|null  $columns  Specific columns to return
     */
    public function addresses(
        array $clients = [],
        array $addresses = [],
        ?int $page = null,
        ?int $limit = null,
        ?array $columns = null,
    ): Response {
        return $this->get(
            DescriptionType::Address,
            $clients,
            $page,
            $limit,
            $columns,
            $addresses === [] ? [] : ['Address' => $addresses],
        );
    }

    /**
     * Get product descriptions.
     *
     * @param  array<string, mixed>  $filters  Filter keys (Codes, Type, Tags, etc.)
     */
    public function products(array $filters = [], ?int $page = null, ?int $limit = null): Response
    {
        return $this->get(DescriptionType::Products, $filters, $page, $limit);
    }

    /**
     * Get client descriptions.
     *
     * @param  array<string, mixed>  $filters  Filter keys (Codes, Group, etc.)
     */
    public function clients(array $filters = [], ?int $page = null, ?int $limit = null): Response
    {
        return $this->get(DescriptionType::Clients, $filters, $page, $limit);
    }

    /**
     * Get service descriptions.
     *
     * @param  array<string, mixed>  $filters
     */
    public function services(array $filters = [], ?int $page = null, ?int $limit = null): Response
    {
        return $this->get(DescriptionType::Services, $filters, $page, $limit);
    }

    /**
     * Get current stock balances.
     *
     * Note: filters are sent under the `Products` key per API docs.
     *
     * @param  array<string, mixed>  $filters
     */
    public function currentStock(array $filters = [], ?int $page = null, ?int $limit = null): Response
    {
        return $this->get(DescriptionType::CurrentStock, $filters, $page, $limit);
    }

    /**
     * Get fixed asset descriptions.
     *
     * @param  array<string, mixed>  $filters
     */
    public function fixedAssets(array $filters = []): Response
    {
        return $this->get(DescriptionType::FixedAsset, $filters);
    }

    /**
     * Get barcode definitions.
     *
     * Note: filters are sent under the `Products` key per API docs.
     *
     * @param  array<string, mixed>  $filters
     */
    public function barCodes(array $filters = []): Response
    {
        return $this->get(DescriptionType::BarCodes, $filters);
    }

    /**
     * Get price list data.
     *
     * @param  array<string, mixed>  $filters
     */
    public function prices(array $filters = []): Response
    {
        return $this->get(DescriptionType::Prices, $filters);
    }

    /**
     * Get tags and types for a given entity type.
     *
     * The API doc example sends `"type": "TypesAndTags"` with a nested
     * `TypesAndTags` object, though the section heading reads "TagsAndTypes".
     * We follow the concrete example.
     *
     * @param  string  $entityType  Entity type identifier (e.g. 'product', 'service', 'client')
     * @param  int  $number  0 = type, 1..N = tag number
     */
    public function typesAndTags(string $entityType, int $number = 0): Response
    {
        return $this->get(DescriptionType::TypesAndTags, [
            'Type' => $entityType,
            'Number' => $number,
        ]);
    }

    /**
     * Get currency exchange rates, optionally filtered by date range and currency codes.
     *
     * @param  list<string>|null  $codes  Currency codes to filter by (e.g. ['USD', 'GBP'])
     */
    public function currencyRates(
        DateTimeInterface|string|null $dateFrom = null,
        DateTimeInterface|string|null $dateTo = null,
        ?array $codes = null,
    ): Response {
        $filters = [];

        if ($dateFrom !== null) {
            $filters['DateFrom'] = $this->formatDate($dateFrom);
        }

        if ($dateTo !== null) {
            $filters['DateTo'] = $this->formatDate($dateTo);
        }

        if ($codes !== null) {
            $filters['Codes'] = $codes;
        }

        return $this->get(DescriptionType::CurrencyRates, $filters);
    }

    /**
     * Get client group definitions.
     */
    public function clientGroups(): Response
    {
        return $this->get(DescriptionType::ClientGroups);
    }

    /**
     * Get warehouse group definitions.
     */
    public function warehouseGroups(): Response
    {
        return $this->get(DescriptionType::WarehouseGroups);
    }

    /**
     * Get logbook (journal) group definitions.
     */
    public function logbookGroups(): Response
    {
        return $this->get(DescriptionType::LogbookGroups);
    }

    /**
     * Get operation type group definitions.
     */
    public function opTypeGroups(): Response
    {
        return $this->get(DescriptionType::OpTypeGroups);
    }

    /**
     * Get document series definitions.
     *
     * Note: filters are sent under the `Series` key per API docs.
     *
     * @param  int|null  $type  0 = invoice series, 1 = settlement series
     * @param  string|null  $userName  Filter by user who has access to the series
     */
    public function documentSeries(?int $type = null, ?string $userName = null): Response
    {
        $filters = [];

        if ($type !== null) {
            $filters['Type'] = $type;
        }

        if ($userName !== null) {
            $filters['UserName'] = $userName;
        }

        return $this->get(DescriptionType::DocumentSeries, $filters);
    }

    /**
     * Get calendar events for a user.
     *
     * @param  string  $userName  The username to retrieve events for
     * @param  array<string, mixed>  $filters  Additional filter keys (DateFrom, DateTo)
     */
    public function calendarEvents(string $userName, array $filters = []): Response
    {
        return $this->get(DescriptionType::CalendarEvents, array_merge(['UserName' => $userName], $filters));
    }

    /**
     * Get vehicle definitions.
     */
    public function vehicles(): Response
    {
        return $this->get(DescriptionType::Vehicles);
    }

    /**
     * Get available invoice templates.
     */
    public function invoiceList(?string $opClass = null): Response
    {
        $filters = $opClass !== null ? ['OpClass' => $opClass] : [];

        return $this->get(DescriptionType::InvoiceList, $filters);
    }

    /**
     * Get available report templates.
     */
    public function reportList(?string $class = null): Response
    {
        $filters = $class !== null ? ['Class' => $class] : [];

        return $this->get(DescriptionType::ReportList, $filters);
    }
}
