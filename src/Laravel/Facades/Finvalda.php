<?php

declare(strict_types=1);

namespace Finvalda\Laravel\Facades;

use Finvalda\Resources\Clients;
use Finvalda\Resources\Descriptions;
use Finvalda\Resources\Documents;
use Finvalda\Resources\Objects;
use Finvalda\Resources\Operations;
use Finvalda\Resources\OrderManagement;
use Finvalda\Resources\Permissions;
use Finvalda\Resources\Pricing;
use Finvalda\Resources\Products;
use Finvalda\Resources\References;
use Finvalda\Resources\Reports;
use Finvalda\Resources\Services;
use Finvalda\Resources\Stock;
use Finvalda\Resources\Transactions;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Stock stock()
 * @method static Clients clients()
 * @method static Products products()
 * @method static Services services()
 * @method static Objects objects()
 * @method static References references()
 * @method static Pricing pricing()
 * @method static Operations operations()
 * @method static OrderManagement orderManagement()
 * @method static Documents documents()
 * @method static Reports reports()
 * @method static Descriptions descriptions()
 * @method static Permissions permissions()
 * @method static Transactions transactions()
 *
 * @see \Finvalda\Finvalda
 */
class Finvalda extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Finvalda\Finvalda::class;
    }
}
