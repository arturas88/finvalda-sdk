<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Enums\ItemClass;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;

/**
 * Product catalog and inventory operations.
 */
final class Products extends Resource
{
    /**
     * Get products as a dataset with optional filtering. Calls GetPrekesSet.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function list(
        ?string $productCode = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetPrekesSet', [
            'sPreKod' => $productCode,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
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
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
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
        ?string $modifiedSince = null,
        ?string $createdSince = null,
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
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
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
     * Get all products with optional date filters. Calls GetPrekes.
     *
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function all(
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetPrekes', [
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get product image data. Calls GetPrekesImage.
     *
     * @param  string  $productCode  The product code
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return only if modified since
     * @return Response
     */
    public function image(string $productCode, ?string $modifiedSince = null): Response
    {
        return $this->http->get('GetPrekesImage', [
            'sPreKod' => $productCode,
            'tKoregavimoData' => $modifiedSince,
        ]);
    }

    /**
     * Get products available in a specific warehouse. Calls GetPrekesSandelyje.
     *
     * @param  string  $warehouseCode  The warehouse code
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function inWarehouse(
        string $warehouseCode,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetPrekesSandelyje', [
            'sSandKod' => $warehouseCode,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get products in a warehouse with custom sort order. Calls GetPrekesSandelyjeOrder.
     *
     * @param  string  $warehouseCode  The warehouse code
     * @param  int|null  $order  Sort column index (determines result ordering)
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function inWarehouseOrdered(
        string $warehouseCode,
        ?int $order = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetPrekesSandelyjeOrder', [
            'sSandKod' => $warehouseCode,
            'nOrder' => $order,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get product types or tags. Calls GetPrekiuRusisPozymius.
     *
     * @param  int  $typeId  0=product type, 1-6=tags 1-6, 9-11=tags 9-11
     * @return Response
     */
    public function typesAndTags(int $typeId = 0): Response
    {
        return $this->http->get('GetPrekiuRusisPozymius', [
            'nID' => $typeId,
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
     * @param  string|null  $dateFrom  Date in Y-m-d format, history start date
     * @return Response
     */
    public function history(
        string $productCode,
        ?string $warehouseCode = null,
        ?string $dateFrom = null,
    ): Response {
        return $this->http->get('GetPrekesIstorija', [
            'sPreKod' => $productCode,
            'sSandKod' => $warehouseCode,
            'tDataNuo' => $dateFrom,
        ]);
    }

    /**
     * Get sold products for a given period. Calls GetPardPrekPerPerioda.
     *
     * @param  string|null  $productCode  Filter by product code
     * @param  string|null  $warehouseCode  Filter by warehouse code
     * @param  string|null  $dateFrom  Date in Y-m-d format, period start
     * @param  string|null  $dateTo  Date in Y-m-d format, period end
     * @param  string|null  $salesJournalCode  Filter by sales journal code
     * @return Response
     */
    public function soldPerPeriod(
        ?string $productCode = null,
        ?string $warehouseCode = null,
        ?string $dateFrom = null,
        ?string $dateTo = null,
        ?string $salesJournalCode = null,
    ): Response {
        return $this->http->get('GetPardPrekPerPerioda', [
            'sPrekesKodas' => $productCode,
            'sSandelioKodas' => $warehouseCode,
            'tDataNuo' => $dateFrom,
            'tDataIki' => $dateTo,
            'sPardZurKodas' => $salesJournalCode,
        ]);
    }

    /**
     * Create a new product. Calls InsertNewItem with Fvs.Preke class.
     *
     * @param  array  $data  Product data (keys: Kodas, Pavadinimas, MatVnt, Kaina, PVMKodas, etc.)
     * @return OperationResult
     */
    public function create(array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::Product->value,
            'xmlstring' => $this->jsonEncode($data),
        ]);
    }

    /**
     * Update an existing product. Calls EditItem with Fvs.Preke class.
     *
     * @param  array  $data  Product data with Kodas identifying the record to update
     * @return OperationResult
     */
    public function update(array $data): OperationResult
    {
        return $this->http->postOperation('EditItem', [
            'ItemClassName' => ItemClass::Product->value,
            'xmlstring' => $this->jsonEncode($data),
        ]);
    }

    /**
     * Edit specific properties of a product. Calls EditItemProps with Fvs.Preke class.
     *
     * @param  string  $productCode  The product code to edit
     * @param  array  $properties  Key-value pairs of properties to update
     * @return OperationResult
     */
    public function editProperties(string $productCode, array $properties): OperationResult
    {
        return $this->http->postOperation('EditItemProps', [
            'ItemClassName' => ItemClass::Product->value,
            'sKodas' => $productCode,
            'xmlstring' => $this->jsonEncode($properties),
        ]);
    }

    /**
     * Delete a product by code. Calls DeleteItem with Fvs.Preke class.
     *
     * @param  string  $productCode  The product code to delete
     * @return OperationResult
     */
    public function delete(string $productCode): OperationResult
    {
        return $this->http->postOperation('DeleteItem', [
            'ItemClassName' => ItemClass::Product->value,
            'sItemCode' => $productCode,
        ]);
    }
}
