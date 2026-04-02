<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Enums\ItemClass;
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
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::Bank->value,
            'xmlstring' => $this->jsonEncode([ItemClass::Bank->value => $data]),
        ]);
    }

    /**
     * Create a new warehouse. Calls InsertNewItem with Fvs.Sandelis class.
     *
     * @param  array  $data  Warehouse data (keys: sKodas, sPavadinimas, etc.)
     */
    public function createWarehouse(array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::Warehouse->value,
            'xmlstring' => $this->jsonEncode([ItemClass::Warehouse->value => $data]),
        ]);
    }

    /**
     * Update an existing warehouse. Calls EditItem with Fvs.Sandelis class.
     *
     * @param  array  $data  Warehouse data with sKodas identifying the record to update
     */
    public function updateWarehouse(array $data): OperationResult
    {
        $code = $data['sKodas'] ?? '';

        return $this->http->postOperation('EditItem', [
            'ItemClassName' => ItemClass::Warehouse->value,
            'sItemCode' => $code,
            'xmlstring' => $this->jsonEncode([ItemClass::Warehouse->value => $data]),
        ]);
    }

    /**
     * Create a new payment term. Calls InsertNewItem with Fvs.AtsTerminas class.
     *
     * @param  array  $data  Payment term data (keys: sKodas, sPavadinimas, nDienos, etc.)
     */
    public function createPaymentTerm(array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::PaymentTerm->value,
            'xmlstring' => $this->jsonEncode([ItemClass::PaymentTerm->value => $data]),
        ]);
    }

    /**
     * Update an existing payment term. Calls EditItem with Fvs.AtsTerminas class.
     *
     * @param  array  $data  Payment term data with sKodas identifying the record to update
     */
    public function updatePaymentTerm(array $data): OperationResult
    {
        $code = $data['sKodas'] ?? '';

        return $this->http->postOperation('EditItem', [
            'ItemClassName' => ItemClass::PaymentTerm->value,
            'sItemCode' => $code,
            'xmlstring' => $this->jsonEncode([ItemClass::PaymentTerm->value => $data]),
        ]);
    }

    /**
     * Create a new client type. Calls InsertNewItem with Fvs.KlientoRusis class.
     *
     * @param  array  $data  Client type data (keys: sKodas, sPavadinimas, etc.)
     */
    public function createClientType(array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::ClientType->value,
            'xmlstring' => $this->jsonEncode([ItemClass::ClientType->value => $data]),
        ]);
    }

    /**
     * Create a new product type. Calls InsertNewItem with Fvs.PrekesRusis class.
     *
     * @param  array  $data  Product type data (keys: sKodas, sPavadinimas, etc.)
     */
    public function createProductType(array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::ProductType->value,
            'xmlstring' => $this->jsonEncode([ItemClass::ProductType->value => $data]),
        ]);
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
