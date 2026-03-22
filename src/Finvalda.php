<?php

declare(strict_types=1);

namespace Finvalda;

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

/**
 * Finvalda API client - main entry point for all resource endpoints.
 *
 * @method Stock stock() Stock and inventory balance operations
 * @method Clients clients() Client (customer/supplier) operations
 * @method Products products() Product catalog and inventory operations
 * @method Services services() Service catalog operations
 * @method Objects objects() Analytical object operations (6 hierarchical levels)
 * @method References references() Reference data (warehouses, units, taxes, banks, payment terms)
 * @method Pricing pricing() Pricing, discounts, and additional prices
 * @method Operations operations() CRUD for sales, purchases, transfers, payments, and other operations
 * @method OrderManagement orderManagement() UVM order management (sales reservations and tracking)
 * @method Documents documents() Document upload, attachment, and management
 * @method Reports reports() Invoice and report PDF generation
 * @method Descriptions descriptions() Universal query endpoint (GetDescriptions) with convenience methods
 * @method Permissions permissions() User permission queries for entity-level access control
 * @method Transactions transactions() Accounting transaction operations
 */
final class Finvalda
{
    private HttpClient $http;

    private ?Stock $stock = null;
    private ?Clients $clients = null;
    private ?Products $products = null;
    private ?Services $services = null;
    private ?Objects $objects = null;
    private ?References $references = null;
    private ?Pricing $pricing = null;
    private ?Operations $operations = null;
    private ?OrderManagement $orderManagement = null;
    private ?Documents $documents = null;
    private ?Reports $reports = null;
    private ?Descriptions $descriptions = null;
    private ?Permissions $permissions = null;
    private ?Transactions $transactions = null;

    /**
     * Create a new Finvalda API client instance.
     *
     * @param  FinvaldaConfig  $config  API connection configuration
     * @param  HttpClient|null  $httpClient  Optional pre-configured HTTP client (for testing or custom middleware)
     */
    public function __construct(FinvaldaConfig $config, ?HttpClient $httpClient = null)
    {
        $this->http = $httpClient ?? new HttpClient($config);
    }

    /**
     * Get the Stock resource for inventory balance operations.
     *
     * @return Stock
     */
    public function stock(): Stock
    {
        return $this->stock ??= new Stock($this->http);
    }

    /**
     * Get the Clients resource for customer/supplier operations.
     *
     * @return Clients
     */
    public function clients(): Clients
    {
        return $this->clients ??= new Clients($this->http);
    }

    /**
     * Get the Products resource for product catalog operations.
     *
     * @return Products
     */
    public function products(): Products
    {
        return $this->products ??= new Products($this->http);
    }

    /**
     * Get the Services resource for service catalog operations.
     *
     * @return Services
     */
    public function services(): Services
    {
        return $this->services ??= new Services($this->http);
    }

    /**
     * Get the Objects resource for analytical object operations.
     *
     * @return Objects
     */
    public function objects(): Objects
    {
        return $this->objects ??= new Objects($this->http);
    }

    /**
     * Get the References resource for reference data operations.
     *
     * @return References
     */
    public function references(): References
    {
        return $this->references ??= new References($this->http);
    }

    /**
     * Get the Pricing resource for discount and price operations.
     *
     * @return Pricing
     */
    public function pricing(): Pricing
    {
        return $this->pricing ??= new Pricing($this->http);
    }

    /**
     * Get the Operations resource for document operation CRUD.
     *
     * @return Operations
     */
    public function operations(): Operations
    {
        return $this->operations ??= new Operations($this->http);
    }

    /**
     * Get the OrderManagement resource for UVM order tracking.
     *
     * @return OrderManagement
     */
    public function orderManagement(): OrderManagement
    {
        return $this->orderManagement ??= new OrderManagement($this->http);
    }

    /**
     * Get the Documents resource for file upload and attachment operations.
     *
     * @return Documents
     */
    public function documents(): Documents
    {
        return $this->documents ??= new Documents($this->http);
    }

    /**
     * Get the Reports resource for PDF generation operations.
     *
     * @return Reports
     */
    public function reports(): Reports
    {
        return $this->reports ??= new Reports($this->http);
    }

    /**
     * Get the Descriptions resource for universal data queries.
     *
     * @return Descriptions
     */
    public function descriptions(): Descriptions
    {
        return $this->descriptions ??= new Descriptions($this->http);
    }

    /**
     * Get the Permissions resource for user access control queries.
     *
     * @return Permissions
     */
    public function permissions(): Permissions
    {
        return $this->permissions ??= new Permissions($this->http);
    }

    /**
     * Get the Transactions resource for accounting transaction operations.
     *
     * @return Transactions
     */
    public function transactions(): Transactions
    {
        return $this->transactions ??= new Transactions($this->http);
    }
}
