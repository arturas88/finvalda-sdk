<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Enums\ItemClass;
use Finvalda\Exceptions\OperationNotSupportedException;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;

/**
 * Reference data (warehouses, measurement units, taxes, banks, payment terms).
 */
final class References extends Resource
{
    /**
     * Get all measurement units. Calls GetMatavimoVienetus.
     *
     * @return Response
     */
    public function measurementUnits(): Response
    {
        return $this->http->get('GetMatavimoVienetus');
    }

    /**
     * Get all warehouses. Calls GetSandelius.
     *
     * @return Response
     */
    public function warehouses(): Response
    {
        return $this->http->get('GetSandelius');
    }

    /**
     * Get all tax definitions. Calls GetMokesciai.
     *
     * @return Response
     */
    public function taxes(): Response
    {
        return $this->http->get('GetMokesciai');
    }

    /**
     * Get all payment terms. Calls GetAtsiskaitymoTerm.
     *
     * @return Response
     */
    public function paymentTerms(): Response
    {
        return $this->http->get('GetAtsiskaitymoTerm');
    }

    /**
     * Get Finvalda user info, optionally validating credentials. Calls GetFvsUser.
     *
     * Security note: the wire format sends sPassword as a GET query parameter,
     * so the password appears in the request URL (server access logs, proxies).
     * The SDK redacts it from its own PSR-3 logs, recordings, and the messages
     * of the exceptions it throws (Guzzle embeds the request URI in its own
     * messages, so its exception is not chained), but the URL exposure is
     * inherent to the endpoint.
     *
     * @param  string|null  $userName  The username to look up
     * @param  string|null  $password  The password to validate
     * @return Response
     */
    public function user(?string $userName = null, ?string $password = null): Response
    {
        return $this->http->get('GetFvsUser', [
            'sUserName' => $userName,
            'sPassword' => $password,
        ]);
    }

    /**
     * Get materially responsible persons. Calls GetMaterialAtsakAsmSar.
     *
     * @param  string|null  $code  Filter by person code
     * @return Response
     */
    public function materiallyResponsiblePersons(?string $code = null): Response
    {
        return $this->http->get('GetMaterialAtsakAsmSar', [
            'sKodas' => $code,
        ]);
    }

    /**
     * Create a new bank record. Calls InsertNewItem with Fvs.Bankas class.
     *
     * @param  array  $data  Bank data (keys: sKodas, sPavadinimas, sSWIFTKodas, etc.)
     */
    public function createBank(array $data): OperationResult
    {
        return $this->insertItem(ItemClass::Bank, $data);
    }

    /**
     * Create a new warehouse. Calls InsertNewItem with Fvs.Sandelis class.
     *
     * @param  array  $data  Warehouse data (keys: sKodas, sPavadinimas, etc.)
     */
    public function createWarehouse(array $data): OperationResult
    {
        return $this->insertItem(ItemClass::Warehouse, $data);
    }

    /**
     * Update an existing warehouse. Calls EditItem with Fvs.Sandelis class.
     *
     * @param  array  $data  Warehouse data with sKodas identifying the record to update
     */
    public function updateWarehouse(array $data): OperationResult
    {
        return $this->editItem(ItemClass::Warehouse, $data);
    }

    /**
     * Create a new payment term. Calls InsertNewItem with Fvs.AtsTerminas class.
     *
     * @param  array  $data  Payment term data (keys: sKodas, sPavadinimas, nDienos, etc.)
     */
    public function createPaymentTerm(array $data): OperationResult
    {
        return $this->insertItem(ItemClass::PaymentTerm, $data);
    }

    /**
     * Update an existing payment term. Calls EditItem with Fvs.AtsTerminas class.
     *
     * @param  array  $data  Payment term data with sKodas identifying the record to update
     */
    public function updatePaymentTerm(array $data): OperationResult
    {
        return $this->editItem(ItemClass::PaymentTerm, $data);
    }

    /**
     * Create a new client type. Calls InsertNewItem with Fvs.KlientoRusis class.
     *
     * @param  array  $data  Client type data (keys: sKodas, sPavadinimas, etc.)
     */
    public function createClientType(array $data): OperationResult
    {
        return $this->insertItem(ItemClass::ClientType, $data);
    }

    /**
     * Create a new product type. Calls InsertNewItem with Fvs.PrekesRusis class.
     *
     * @param  array  $data  Product type data (keys: sKodas, sPavadinimas, etc.)
     */
    public function createProductType(array $data): OperationResult
    {
        return $this->insertItem(ItemClass::ProductType, $data);
    }

    /**
     * Create a new product tag value. Calls InsertNewItem with Fvs.PrekesPoz{N} class.
     *
     * @param  int  $tagNumber  Tag number (1-20)
     * @param  array  $data  Tag data (keys: sKodas, sPavadinimas, sInformacija1, sInformacija2)
     */
    public function createProductTag(int $tagNumber, array $data): OperationResult
    {
        return $this->insertItem(ItemClass::productTag($tagNumber), $data);
    }

    /**
     * Create a new client tag value. Calls InsertNewItem with Fvs.Kliento{I|II|III}Poz class.
     *
     * @param  int  $tagNumber  Tag number (1-3)
     * @param  array  $data  Tag data (keys: sKodas, sPavadinimas, etc.)
     */
    public function createClientTag(int $tagNumber, array $data): OperationResult
    {
        return $this->insertItem(ItemClass::clientTag($tagNumber), $data);
    }

    /**
     * Update a product type. Calls EditItem with Fvs.PrekesRusis class.
     *
     * @param  array  $data  Type data with sKodas identifying the record to update.
     */
    public function updateProductType(array $data): OperationResult
    {
        return $this->editItem(ItemClass::ProductType, $data);
    }

    /**
     * Update a product tag value. Calls EditItem with Fvs.PrekesPoz{N} class.
     *
     * @param  int  $tagNumber  Tag number (1-20)
     * @param  array  $data  Tag data with sKodas identifying the record to update.
     */
    public function updateProductTag(int $tagNumber, array $data): OperationResult
    {
        return $this->editItem(ItemClass::productTag($tagNumber), $data);
    }

    /**
     * Update a client type. Calls EditItem with Fvs.KlientoRusis class.
     *
     * @param  array  $data  Type data with sKodas identifying the record to update.
     */
    public function updateClientType(array $data): OperationResult
    {
        return $this->editItem(ItemClass::ClientType, $data);
    }

    /**
     * Update a client tag value. Calls EditItem with Fvs.Kliento{I|II|III}Poz class.
     *
     * @param  int  $tagNumber  Tag number (1-3)
     * @param  array  $data  Tag data with sKodas identifying the record to update.
     */
    public function updateClientTag(int $tagNumber, array $data): OperationResult
    {
        return $this->editItem(ItemClass::clientTag($tagNumber), $data);
    }

    /**
     * Delete a product type by code. Calls DeleteItem with Fvs.PrekesRusis class.
     *
     * Requires a FvsServicePure build that exposes DeleteItem (older builds 404).
     *
     * @throws OperationNotSupportedException when the server build lacks DeleteItem
     */
    public function deleteProductType(string $code): OperationResult
    {
        return $this->deleteItem(ItemClass::ProductType, $code);
    }

    /**
     * Delete a product tag value by code. Calls DeleteItem with Fvs.PrekesPoz{N} class.
     *
     * Requires a FvsServicePure build that exposes DeleteItem (older builds 404).
     *
     * @param  int  $tagNumber  Tag number (1-20)
     *
     * @throws OperationNotSupportedException when the server build lacks DeleteItem
     */
    public function deleteProductTag(int $tagNumber, string $code): OperationResult
    {
        return $this->deleteItem(ItemClass::productTag($tagNumber), $code);
    }

    /**
     * Delete a client type by code. Calls DeleteItem with Fvs.KlientoRusis class.
     *
     * Requires a FvsServicePure build that exposes DeleteItem (older builds 404).
     *
     * @throws OperationNotSupportedException when the server build lacks DeleteItem
     */
    public function deleteClientType(string $code): OperationResult
    {
        return $this->deleteItem(ItemClass::ClientType, $code);
    }

    /**
     * Delete a client tag value by code. Calls DeleteItem with Fvs.Kliento{I|II|III}Poz class.
     *
     * Requires a FvsServicePure build that exposes DeleteItem (older builds 404).
     *
     * @param  int  $tagNumber  Tag number (1-3)
     *
     * @throws OperationNotSupportedException when the server build lacks DeleteItem
     */
    public function deleteClientTag(int $tagNumber, string $code): OperationResult
    {
        return $this->deleteItem(ItemClass::clientTag($tagNumber), $code);
    }

    /**
     * Add an item to a group. Calls AppendGroup.
     *
     * @param  string  $itemClassName  The Finvalda item class name (e.g., 'Fvs.Klientas')
     * @param  string  $groupCode  The group code to add the item to
     * @param  string  $itemCode  The item code to add
     * @param  string|null  $itemCode2  Secondary item code (for composite keys)
     * @return OperationResult
     */
    public function addToGroup(string $itemClassName, string $groupCode, string $itemCode, ?string $itemCode2 = null): OperationResult
    {
        return $this->http->postOperation('AppendGroup', [
            'ItemClassName' => $itemClassName,
            'sGroupCode' => $groupCode,
            'sItemCode' => $itemCode,
            'sItemCode2' => $itemCode2,
        ]);
    }
}
