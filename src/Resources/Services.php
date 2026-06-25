<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
use Finvalda\Collections\ServiceCollection;
use Finvalda\Collections\TypeTagCollection;
use Finvalda\Concerns\QueriesTypeTags;
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
    use QueriesTypeTags;

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

        $data = $this->extractEntity($response, ItemClass::Service);

        if ($data === null) {
            throw new NotFoundException("Service '{$serviceCode}' not found");
        }

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
     * Get one service type/tag group from the dictionary. Calls GetPaslauguRusisPozymius.
     *
     * The endpoint returns the FULL dictionary (all types and tag groups) in a
     * single call; the legacy `nID` request parameter is ignored by the server.
     * This method fetches that dictionary once (cached) and returns only the rows
     * whose `tipas` matches $typeId.
     *
     * Service `tipas` mapping: 18=Type, 15=Tag1, 16=Tag2, 17=Tag3 (note the
     * non-sequential numbering). Tag groups the server has not configured return
     * an empty collection — that is normal.
     *
     * @param  ServiceTypeId|int  $typeId  Type/tag discriminator (ServiceTypeId or raw int)
     */
    public function typesAndTags(ServiceTypeId|int $typeId = ServiceTypeId::Type): TypeTagCollection
    {
        return $this->fetchTypeTags('GetPaslauguRusisPozymius')->whereType($typeId);
    }

    /**
     * Get the WHOLE service type/tag dictionary in one call. Calls GetPaslauguRusisPozymius.
     *
     * Returns every type and tag group as one collection. Use ->groupByType()
     * for an array keyed by `tipas`. The underlying request is cached, so this
     * shares its round-trip with typesAndTags().
     */
    public function allTypesAndTags(): TypeTagCollection
    {
        return $this->fetchTypeTags('GetPaslauguRusisPozymius');
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
            'xmlstring' => $this->jsonEncode([ItemClass::Service->value => $data]),
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
            'xmlstring' => $this->jsonEncode([ItemClass::Service->value => $data]),
        ]);
    }

    /**
     * Delete a service by code. Calls DeleteItem with Fvs.Paslauga class.
     *
     * @param  string  $serviceCode  The service code to delete
     */
    public function delete(string $serviceCode): OperationResult
    {
        return $this->http->postOperationJson('DeleteItem', [
            'input' => [
                'ItemClassName' => ItemClass::Service->value,
                'Code' => $serviceCode,
            ],
        ]);
    }
}
