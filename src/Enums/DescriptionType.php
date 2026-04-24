<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Type values for GetDescriptions.
 *
 * Each case knows its wire-format filter key (the nested object name the API
 * expects filter parameters under). Most types use the same name, but several
 * diverge - see filterKey() for the authoritative mapping per docs.
 */
enum DescriptionType: string
{
    case StockOnDate = 'StockOnDate';
    case FixedAsset = 'FixedAsset';
    case Products = 'Products';
    case CurrentStock = 'CurrentStock';
    case CurrentStockDet = 'CurrentStockDet';
    case PartnerProducts = 'PartnerProducts';
    case InvoiceList = 'InvoiceList';
    case ReportList = 'ReportList';
    case DocumentSeries = 'DocumentSeries';
    case CountSales = 'CountSales';
    case CountClients = 'CountClients';
    case ClientGroups = 'ClientGroups';
    case LogbookGroups = 'LogbookGroups';
    case OpTypeGroups = 'OpTypeGroups';
    case WarehouseGroups = 'WarehouseGroups';
    case CalendarEvents = 'CalendarEvents';
    case CompanyWorkStart = 'CompanyWorkStart';
    case Vehicles = 'Vehicles';
    case Clients = 'Clients';
    case Address = 'Address';
    case ProductionItem = 'ProductionItem';
    case Services = 'Services';
    case Prices = 'Prices';
    case PricesByItemType = 'PricesByItemType';
    case PricesByClientType = 'PricesByClientType';
    case PricesByClientAndItemTypes = 'PricesByClientAndItemTypes';
    case BarCodes = 'BarCodes';
    case TypesAndTags = 'TypesAndTags';
    case CurrencyRates = 'CurrencyRates';
    case OperationStatuses = 'OperationStatuses';
    case Accounts = 'Accounts';

    /**
     * The nested object key the API expects filter parameters under, or null
     * for types that accept no filter (just page/limit/columns).
     */
    public function filterKey(): ?string
    {
        return match ($this) {
            self::CurrentStock, self::BarCodes, self::ProductionItem => 'Products',
            self::Address => 'Clients',
            self::DocumentSeries => 'Series',
            self::CountSales, self::CountClients => 'CountFilter',
            self::PricesByItemType, self::PricesByClientType, self::PricesByClientAndItemTypes => 'Prices',
            self::ClientGroups,
            self::LogbookGroups,
            self::OpTypeGroups,
            self::WarehouseGroups,
            self::CompanyWorkStart,
            self::Vehicles => null,
            default => $this->value,
        };
    }
}
