<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
use Finvalda\Collections\ProductCollection;
use Finvalda\Concerns\DecodesBinaryResponse;
use Finvalda\Data\Product;
use Finvalda\Enums\ItemClass;
use Finvalda\Enums\ProductTypeId;
use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Exceptions\NotFoundException;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;

/**
 * Product catalog and inventory operations.
 */
final class Products extends Resource
{
    use DecodesBinaryResponse;

    /**
     * Get products as a dataset with optional filtering. Calls GetPrekesSet.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function list(
        ?string $productCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetPrekesSet', [
            'sPreKod' => $productCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get products with extended filtering by type, tags, suppliers, and objects. Calls GetPrekesSetExt.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $type  Filter by product type code
     * @param  string|null  $tag1  Filter by tag 1 code
     * @param  string|null  $tag2  Filter by tag 2 code
     * @param  string|null  $tag3  Filter by tag 3 code
     * @param  string|null  $tag4  Filter by tag 4 code
     * @param  string|null  $tag5  Filter by tag 5 code
     * @param  string|null  $tag6  Filter by tag 6 code
     * @param  string|null  $supplier1  Filter by supplier 1 code
     * @param  string|null  $supplier2  Filter by supplier 2 code
     * @param  string|null  $supplier3  Filter by supplier 3 code
     * @param  string|null  $accountLink  Filter by account link code
     * @param  string|null  $object1  Filter by object level 1 code
     * @param  string|null  $object2  Filter by object level 2 code
     * @param  string|null  $object3  Filter by object level 3 code
     * @param  string|null  $object4  Filter by object level 4 code
     * @param  string|null  $object5  Filter by object level 5 code
     * @param  string|null  $object6  Filter by object level 6 code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function listExtended(
        ?string $productCode = null,
        ?string $type = null,
        ?string $tag1 = null,
        ?string $tag2 = null,
        ?string $tag3 = null,
        ?string $tag4 = null,
        ?string $tag5 = null,
        ?string $tag6 = null,
        ?string $supplier1 = null,
        ?string $supplier2 = null,
        ?string $supplier3 = null,
        ?string $accountLink = null,
        ?string $object1 = null,
        ?string $object2 = null,
        ?string $object3 = null,
        ?string $object4 = null,
        ?string $object5 = null,
        ?string $object6 = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetPrekesSetExt', [
            'sPreKod' => $productCode,
            'sRusis' => $type,
            'sPozymis1' => $tag1,
            'sPozymis2' => $tag2,
            'sPozymis3' => $tag3,
            'sPozymis4' => $tag4,
            'sPozymis5' => $tag5,
            'sPozymis6' => $tag6,
            'sTiekejas1' => $supplier1,
            'sTiekejas2' => $supplier2,
            'sTiekejas3' => $supplier3,
            'sRysysSuSask' => $accountLink,
            'sObj1' => $object1,
            'sObj2' => $object2,
            'sObj3' => $object3,
            'sObj4' => $object4,
            'sObj5' => $object5,
            'sObj6' => $object6,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get a single product by code. Calls GetPreke.
     *
     * @param  string  $productCode  The product code
     * @return Response
     */
    public function get(string $productCode): Response
    {
        return $this->http->get('GetPreke', [
            'sPrekesKodas' => $productCode,
        ]);
    }

    /**
     * Find a single product by code and return as typed DTO.
     *
     * @param  string  $productCode  The product code
     * @return Product
     *
     * @throws NotFoundException
     */
    public function find(string $productCode): Product
    {
        $response = $this->get($productCode);

        if (! $response->successful() || empty($response->data)) {
            throw new NotFoundException("Product '{$productCode}' not found");
        }

        $data = is_array($response->data[0] ?? null) ? $response->data[0] : $response->data;

        return Product::fromArray($data);
    }

    /**
     * Get all products as a typed collection.
     *
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     * @return ProductCollection
     */
    public function collect(
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): ProductCollection {
        $response = $this->all($modifiedSince, $createdSince);

        if (! $response->successful()) {
            return new ProductCollection();
        }

        return ProductCollection::fromArray($response->data);
    }

    /**
     * Get all products with optional date filters. Calls GetPrekes.
     *
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function all(
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetPrekes', [
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get product image envelope. Calls GetPrekesImage.
     *
     * The Pure service wraps the JPG payload as base64 inside `fileContents`.
     * Use `imageJpeg()` when you want raw bytes.
     *
     * @param  string  $productCode  The product code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return only if modified since this date
     */
    public function image(string $productCode, DateTimeInterface|string|null $modifiedSince = null): Response
    {
        return $this->http->get('GetPrekesImage', [
            'sPreKod' => $productCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
        ]);
    }

    /**
     * Get a product image and return the decoded JPG bytes.
     *
     * @throws FinvaldaException
     */
    public function imageJpeg(string $productCode, DateTimeInterface|string|null $modifiedSince = null): string
    {
        return $this->decodeBinaryResponse(
            $this->image($productCode, $modifiedSince),
            'GetPrekesImage',
        );
    }

    /**
     * Get products available in a specific warehouse. Calls GetPrekesSandelyje.
     *
     * @param  string  $warehouseCode  The warehouse code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function inWarehouse(
        string $warehouseCode,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetPrekesSandelyje', [
            'sSandKod' => $warehouseCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get products in a warehouse with custom sort order. Calls GetPrekesSandelyjeOrder.
     *
     * @param  string  $warehouseCode  The warehouse code
     * @param  int|null  $order  Sort column index (determines result ordering)
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function inWarehouseOrdered(
        string $warehouseCode,
        ?int $order = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetPrekesSandelyjeOrder', [
            'sSandKod' => $warehouseCode,
            'nOrder' => $order,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get product types or tags. Calls GetPrekiuRusisPozymius.
     *
     * @param  ProductTypeId|int  $typeId  Use ProductTypeId enum or: 0=product type, 1-6=tags 1-6, 9-11=tags 9-11
     * @return Response
     */
    public function typesAndTags(ProductTypeId|int $typeId = ProductTypeId::Type): Response
    {
        $id = $typeId instanceof ProductTypeId ? $typeId->value : $typeId;

        return $this->http->get('GetPrekiuRusisPozymius', [
            'nID' => $id,
        ]);
    }

    /**
     * Get product type groups. Calls GetPrekiuRusiuGrupes.
     *
     * @return Response
     */
    public function typeGroups(): Response
    {
        return $this->http->get('GetPrekiuRusiuGrupes');
    }

    /**
     * Get products within a type group. Calls GetPrekiuRusiuGrupesSudeti.
     *
     * @param  string  $typeGroupCode  The product type group code
     * @return Response
     */
    public function typeGroupComposition(string $typeGroupCode): Response
    {
        return $this->http->get('GetPrekiuRusiuGrupesSudeti', [
            'sPrekiuRusiuGrupe' => $typeGroupCode,
        ]);
    }

    /**
     * Get products belonging to a specific type. Calls GetPrekiuRusiesSudeti.
     *
     * @param  string  $typeCode  The product type code
     * @return Response
     */
    public function byType(string $typeCode): Response
    {
        return $this->http->get('GetPrekiuRusiesSudeti', [
            'sRusiesKodas' => $typeCode,
        ]);
    }

    /**
     * Get product movement history. Calls GetPrekesIstorija.
     *
     * @param  string  $productCode  The product code
     * @param  string|null  $warehouseCode  Filter by warehouse code
     * @param  DateTimeInterface|string|null  $dateFrom  History start date
     */
    public function history(
        string $productCode,
        ?string $warehouseCode = null,
        DateTimeInterface|string|null $dateFrom = null,
    ): Response {
        return $this->http->get('GetPrekesIstorija', [
            'sPreKod' => $productCode,
            'sSandKod' => $warehouseCode,
            'tDataNuo' => $this->formatDate($dateFrom),
        ]);
    }

    /**
     * Get sold products for a given period. Calls GetPardPrekPerPerioda.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseCode  Filter by warehouse code
     * @param  DateTimeInterface|string|null  $dateFrom  Period start date
     * @param  DateTimeInterface|string|null  $dateTo  Period end date
     * @param  string|null  $salesJournalCode  Filter by sales journal code
     */
    public function soldPerPeriod(
        ?string $productCode = null,
        ?string $warehouseCode = null,
        DateTimeInterface|string|null $dateFrom = null,
        DateTimeInterface|string|null $dateTo = null,
        ?string $salesJournalCode = null,
    ): Response {
        return $this->http->get('GetPardPrekPerPerioda', [
            'sPrekesKodas' => $productCode,
            'sSandelioKodas' => $warehouseCode,
            'tDataNuo' => $this->formatDate($dateFrom),
            'tDataIki' => $this->formatDate($dateTo),
            'sPardZurKodas' => $salesJournalCode,
        ]);
    }

    /**
     * Create a new product. Calls InsertNewItem with Fvs.Preke class.
     *
     * @param  array  $data  Product data (keys: sKodas, sPavadinimas, sMatVnt, dKaina, sPVMKodas, etc.)
     *                       If your server requires it, include sFvsImportoParametras in the data array.
     *                       This is a server-configured import handler parameter.
     */
    public function create(array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::Product->value,
            'xmlstring' => $this->jsonEncode([ItemClass::Product->value => $data]),
        ]);
    }

    /**
     * Update an existing product. Calls EditItem with Fvs.Preke class.
     *
     * @param  array  $data  Product data with sKodas identifying the record to update.
     *                       If your server requires it, include sFvsImportoParametras in the data array.
     *                       This is a server-configured import handler parameter.
     */
    public function update(array $data): OperationResult
    {
        $code = $data['sKodas'] ?? '';

        return $this->http->postOperation('EditItem', [
            'ItemClassName' => ItemClass::Product->value,
            'sItemCode' => $code,
            'xmlstring' => $this->jsonEncode([ItemClass::Product->value => $data]),
        ]);
    }

    /**
     * Bulk edit product properties. Calls EditItemProps with Fvs.Prekes wrapper.
     *
     * Data should contain 'Kodas' (array of product codes) and properties to set.
     * Example: ['Kodas' => ['PRD001', 'PRD002'], 'pardKaina1' => '15.81']
     *
     * @param  array  $data  Product codes and properties to update
     */
    public function editProperties(array $data): OperationResult
    {
        return $this->http->postOperation('EditItemProps', [
            'xmlstring' => $this->jsonEncode(['Fvs.EditItemProps' => ['Fvs.Prekes' => $data]]),
        ]);
    }

    /**
     * Delete a product by code. Calls DeleteItem with Fvs.Preke class.
     *
     * @param  string  $productCode  The product code to delete
     */
    public function delete(string $productCode): OperationResult
    {
        return $this->http->postOperationJson('DeleteItem', [
            'input' => [
                'ItemClassName' => ItemClass::Product->value,
                'Code' => $productCode,
            ],
        ]);
    }
}
