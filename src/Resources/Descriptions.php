<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Enums\DescriptionType;
use Finvalda\Responses\Response;

/**
 * Universal query endpoint (GetDescriptions) with convenience methods for common data types.
 */
final class Descriptions extends Resource
{
    /**
     * Query descriptions with flexible filtering and pagination. Calls GetDescriptions.
     *
     * @param  DescriptionType  $type  The data type to query
     * @param  array  $filters  Additional filter key-value pairs
     * @param  int|null  $page  Page number for pagination
     * @param  int|null  $limit  Number of records per page
     * @param  array|null  $columns  Specific columns to return
     * @return Response
     */
    public function get(DescriptionType $type, array $filters = [], ?int $page = null, ?int $limit = null, ?array $columns = null): Response
    {
        $data = array_merge([
            'Type' => $type->value,
        ], $filters);

        if ($page !== null) {
            $data['page'] = $page;
        }

        if ($limit !== null) {
            $data['limit'] = $limit;
        }

        if ($columns !== null) {
            $data['columns'] = $columns;
        }

        return $this->http->postJson('GetDescriptions', $data);
    }

    // Convenience methods for common types

    /**
     * Get stock quantities as of a specific date.
     *
     * @param  string  $date  Date in Y-m-d format, the snapshot date
     * @param  array  $filters  Additional filter key-value pairs
     * @return Response
     */
    public function stockOnDate(string $date, array $filters = []): Response
    {
        return $this->get(DescriptionType::StockOnDate, array_merge(['Date' => $date], $filters));
    }

    /**
     * Get product descriptions with optional filtering and pagination.
     *
     * @param  array  $filters  Additional filter key-value pairs
     * @param  int|null  $page  Page number for pagination
     * @param  int|null  $limit  Number of records per page
     * @return Response
     */
    public function products(array $filters = [], ?int $page = null, ?int $limit = null): Response
    {
        return $this->get(DescriptionType::Products, $filters, $page, $limit);
    }

    /**
     * Get client descriptions with optional filtering and pagination.
     *
     * @param  array  $filters  Additional filter key-value pairs
     * @param  int|null  $page  Page number for pagination
     * @param  int|null  $limit  Number of records per page
     * @return Response
     */
    public function clients(array $filters = [], ?int $page = null, ?int $limit = null): Response
    {
        return $this->get(DescriptionType::Clients, $filters, $page, $limit);
    }

    /**
     * Get service descriptions with optional filtering and pagination.
     *
     * @param  array  $filters  Additional filter key-value pairs
     * @param  int|null  $page  Page number for pagination
     * @param  int|null  $limit  Number of records per page
     * @return Response
     */
    public function services(array $filters = [], ?int $page = null, ?int $limit = null): Response
    {
        return $this->get(DescriptionType::Services, $filters, $page, $limit);
    }

    /**
     * Get current stock balances with optional filtering and pagination.
     *
     * @param  array  $filters  Additional filter key-value pairs
     * @param  int|null  $page  Page number for pagination
     * @param  int|null  $limit  Number of records per page
     * @return Response
     */
    public function currentStock(array $filters = [], ?int $page = null, ?int $limit = null): Response
    {
        return $this->get(DescriptionType::CurrentStock, $filters, $page, $limit);
    }

    /**
     * Get fixed asset descriptions.
     *
     * @param  array  $filters  Additional filter key-value pairs
     * @return Response
     */
    public function fixedAssets(array $filters = []): Response
    {
        return $this->get(DescriptionType::FixedAsset, $filters);
    }

    /**
     * Get barcode definitions.
     *
     * @param  array  $filters  Additional filter key-value pairs
     * @return Response
     */
    public function barCodes(array $filters = []): Response
    {
        return $this->get(DescriptionType::BarCodes, $filters);
    }

    /**
     * Get price list data.
     *
     * @param  array  $filters  Additional filter key-value pairs
     * @return Response
     */
    public function prices(array $filters = []): Response
    {
        return $this->get(DescriptionType::Prices, $filters);
    }

    /**
     * Get tags and types for a given entity type.
     *
     * Note: For this endpoint, the API 'Type' field is the entity type string,
     * not the DescriptionType enum value.
     *
     * @param  string  $entityType  The entity type identifier (e.g., 'product', 'service', 'client', 'address', 'contract', 'fixedasset', 'lowvalueinventory')
     * @param  int  $number  0=type, 1..N=tag number
     * @return Response
     */
    public function tagsAndTypes(string $entityType, int $number = 0): Response
    {
        return $this->http->postJson('GetDescriptions', [
            'Type' => $entityType,
            'Number' => $number,
        ]);
    }

    /**
     * Get currency exchange rates, optionally filtered by date range and currency codes.
     *
     * @param  string|null  $dateFrom  Date in Y-m-d format, range start
     * @param  string|null  $dateTo  Date in Y-m-d format, range end
     * @param  array|null  $codes  Currency codes to filter by (e.g., ['USD', 'GBP'])
     * @return Response
     */
    public function currencyRates(?string $dateFrom = null, ?string $dateTo = null, ?array $codes = null): Response
    {
        $filters = [];
        if ($dateFrom !== null) {
            $filters['DateFrom'] = $dateFrom;
        }
        if ($dateTo !== null) {
            $filters['DateTo'] = $dateTo;
        }
        if ($codes !== null) {
            $filters['Codes'] = $codes;
        }

        return $this->get(DescriptionType::CurrencyRates, $filters);
    }

    /**
     * Get client group definitions.
     *
     * @return Response
     */
    public function clientGroups(): Response
    {
        return $this->get(DescriptionType::ClientGroups);
    }

    /**
     * Get warehouse group definitions.
     *
     * @return Response
     */
    public function warehouseGroups(): Response
    {
        return $this->get(DescriptionType::WarehouseGroups);
    }

    /**
     * Get logbook (journal) group definitions.
     *
     * @return Response
     */
    public function logbookGroups(): Response
    {
        return $this->get(DescriptionType::LogbookGroups);
    }

    /**
     * Get operation type group definitions.
     *
     * @return Response
     */
    public function opTypeGroups(): Response
    {
        return $this->get(DescriptionType::OpTypeGroups);
    }

    /**
     * Get document series definitions.
     *
     * @param  int|null  $type  0=invoice series, 1=settlement series
     * @param  string|null  $userName  Filter by user who has access to the series
     * @return Response
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
     * @param  array  $filters  Additional filter key-value pairs (e.g., DateFrom, DateTo)
     * @return Response
     */
    public function calendarEvents(string $userName, array $filters = []): Response
    {
        return $this->get(DescriptionType::CalendarEvents, array_merge(['UserName' => $userName], $filters));
    }

    /**
     * Get vehicle definitions.
     *
     * @return Response
     */
    public function vehicles(): Response
    {
        return $this->get(DescriptionType::Vehicles);
    }

    /**
     * Get available invoice templates.
     *
     * @param  string|null  $opClass  Filter by operation class
     * @return Response
     */
    public function invoiceList(?string $opClass = null): Response
    {
        $filters = $opClass ? ['OpClass' => $opClass] : [];

        return $this->get(DescriptionType::InvoiceList, $filters);
    }

    /**
     * Get available report templates.
     *
     * @param  string|null  $class  Filter by report class
     * @return Response
     */
    public function reportList(?string $class = null): Response
    {
        $filters = $class ? ['Class' => $class] : [];

        return $this->get(DescriptionType::ReportList, $filters);
    }
}
