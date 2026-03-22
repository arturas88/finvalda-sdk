<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Enums\ItemClass;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;

/**
 * Service catalog operations.
 */
final class Services extends Resource
{
    /**
     * Get services as a dataset with optional filtering. Calls GetPaslaugosSet.
     *
     * @param  string|null  $serviceCode  Filter by service code
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function list(
        ?string $serviceCode = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetPaslaugosSet', [
            'sPasKod' => $serviceCode,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get a single service by code. Calls GetPaslauga.
     *
     * @param  string  $serviceCode  The service code
     * @return Response
     */
    public function get(string $serviceCode): Response
    {
        return $this->http->get('GetPaslauga', [
            'sPaslaugosKodas' => $serviceCode,
        ]);
    }

    /**
     * Get all services with optional date filters. Calls GetPaslaugos.
     *
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function all(
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetPaslaugos', [
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get service types or tags. Calls GetPaslauguRusisPozymius.
     *
     * @param  int  $typeId  18=service type, 15=tag 1, 16=tag 2, 17=tag 3
     * @return Response
     */
    public function typesAndTags(int $typeId = 18): Response
    {
        return $this->http->get('GetPaslauguRusisPozymius', [
            'nID' => $typeId,
        ]);
    }

    /**
     * Get services belonging to a specific type. Calls GetPaslauguRusiesSudeti.
     *
     * @param  string  $typeCode  The service type code
     * @return Response
     */
    public function byType(string $typeCode): Response
    {
        return $this->http->get('GetPaslauguRusiesSudeti', [
            'sRusiesKodas' => $typeCode,
        ]);
    }

    /**
     * Create a new service. Calls InsertNewItem with Fvs.Paslauga class.
     *
     * @param  array  $data  Service data (keys: Kodas, Pavadinimas, Kaina, PVMKodas, etc.)
     * @return OperationResult
     */
    public function create(array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::Service->value,
            'xmlstring' => $this->jsonEncode($data),
        ]);
    }

    /**
     * Update an existing service. Calls EditItem with Fvs.Paslauga class.
     *
     * @param  array  $data  Service data with Kodas identifying the record to update
     * @return OperationResult
     */
    public function update(array $data): OperationResult
    {
        return $this->http->postOperation('EditItem', [
            'ItemClassName' => ItemClass::Service->value,
            'xmlstring' => $this->jsonEncode($data),
        ]);
    }

    /**
     * Delete a service by code. Calls DeleteItem with Fvs.Paslauga class.
     *
     * @param  string  $serviceCode  The service code to delete
     * @return OperationResult
     */
    public function delete(string $serviceCode): OperationResult
    {
        return $this->http->postOperation('DeleteItem', [
            'ItemClassName' => ItemClass::Service->value,
            'sItemCode' => $serviceCode,
        ]);
    }
}
