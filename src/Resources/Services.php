<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
use Finvalda\Collections\ServiceCollection;
use Finvalda\Data\Service;
use Finvalda\Enums\ItemClass;
use Finvalda\Enums\ServiceTypeId;
use Finvalda\Exceptions\NotFoundException;
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
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function list(
        ?string $serviceCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetPaslaugosSet', [
            'sPasKod' => $serviceCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
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
     * Find a single service by code and return as typed DTO.
     *
     * @param  string  $serviceCode  The service code
     * @return Service
     *
     * @throws NotFoundException
     */
    public function find(string $serviceCode): Service
    {
        $response = $this->get($serviceCode);

        if (! $response->successful() || empty($response->data)) {
            throw new NotFoundException("Service '{$serviceCode}' not found");
        }

        $data = is_array($response->data[0] ?? null) ? $response->data[0] : $response->data;

        return Service::fromArray($data);
    }

    /**
     * Get all services as a typed collection.
     *
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     * @return ServiceCollection
     */
    public function collect(
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): ServiceCollection {
        $response = $this->all($modifiedSince, $createdSince);

        if (! $response->successful()) {
            return new ServiceCollection();
        }

        return ServiceCollection::fromArray($response->data);
    }

    /**
     * Get all services with optional date filters. Calls GetPaslaugos.
     *
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function all(
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetPaslaugos', [
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get service types or tags. Calls GetPaslauguRusisPozymius.
     *
     * @param  ServiceTypeId|int  $typeId  Use ServiceTypeId enum or: 18=service type, 15=tag 1, 16=tag 2, 17=tag 3
     * @return Response
     */
    public function typesAndTags(ServiceTypeId|int $typeId = ServiceTypeId::Type): Response
    {
        $id = $typeId instanceof ServiceTypeId ? $typeId->value : $typeId;

        return $this->http->get('GetPaslauguRusisPozymius', [
            'nID' => $id,
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
     * @param  array  $data  Service data (keys: sKodas, sPavadinimas, dKaina, sPVMKodas, etc.)
     *                       If your server requires it, include sFvsImportoParametras in the data array.
     *                       This is a server-configured import handler parameter.
     */
    public function create(array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::Service->value,
            'xmlString' => $this->jsonEncode([ItemClass::Service->value => $data]),
        ]);
    }

    /**
     * Update an existing service. Calls EditItem with Fvs.Paslauga class.
     *
     * @param  array  $data  Service data with sKodas identifying the record to update.
     *                       If your server requires it, include sFvsImportoParametras in the data array.
     *                       This is a server-configured import handler parameter.
     */
    public function update(array $data): OperationResult
    {
        $code = $data['sKodas'] ?? '';

        return $this->http->postOperation('EditItem', [
            'ItemClassName' => ItemClass::Service->value,
            'sItemCode' => $code,
            'xmlString' => $this->jsonEncode([ItemClass::Service->value => $data]),
        ]);
    }

    /**
     * Delete a service by code. Calls DeleteItem with Fvs.Paslauga class.
     *
     * @param  string  $serviceCode  The service code to delete
     */
    public function delete(string $serviceCode): OperationResult
    {
        return $this->http->postOperation('DeleteItem', [
            'ItemClassName' => ItemClass::Service->value,
            'sItemCode' => $serviceCode,
        ]);
    }
}
