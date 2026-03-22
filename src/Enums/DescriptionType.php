<?php

declare(strict_types=1);

namespace Finvalda\Enums;

/**
 * Type values for GetDescriptions.
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
    case TagsAndTypes = 'TagsAndTypes';
    case CurrencyRates = 'CurrencyRates';
}
