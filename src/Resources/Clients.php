<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
use Finvalda\Collections\ClientCollection;
use Finvalda\Data\Client;
use Finvalda\Enums\ClientTypeId;
use Finvalda\Enums\ItemClass;
use Finvalda\Exceptions\NotFoundException;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;

/**
 * Client (customer/supplier) operations.
 */
final class Clients extends Resource
{
    /**
     * Get clients as a dataset with optional filtering. Calls GetKlientusSet.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function list(
        ?string $clientCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientusSet', [
            'sKliKod' => $clientCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get a single client by code. Calls GetKlientas.
     *
     * @param  string  $clientCode  The client code
     * @return Response
     */
    public function get(string $clientCode): Response
    {
        return $this->http->get('GetKlientas', [
            'sKliKod' => $clientCode,
        ]);
    }

    /**
     * Find a single client by code and return as typed DTO.
     *
     * @param  string  $clientCode  The client code
     * @return Client
     *
     * @throws NotFoundException
     */
    public function find(string $clientCode): Client
    {
        $response = $this->get($clientCode);

        if (! $response->successful() || empty($response->data)) {
            throw new NotFoundException("Client '{$clientCode}' not found");
        }

        $data = is_array($response->data[0] ?? null) ? $response->data[0] : $response->data;

        return Client::fromArray($data);
    }

    /**
     * Get all clients as a typed collection.
     *
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     * @return ClientCollection
     */
    public function collect(
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): ClientCollection {
        $response = $this->all($modifiedSince, $createdSince);

        if (! $response->successful()) {
            return new ClientCollection();
        }

        return ClientCollection::fromArray($response->data);
    }

    /**
     * Get all clients with optional date filters. Calls GetKlientus.
     *
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function all(
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientus', [
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
        ]);
    }

    /**
     * Get a client's email address. Calls GetKlientasEMail.
     *
     * @param  string  $clientCode  The client code
     * @return Response
     */
    public function email(string $clientCode): Response
    {
        return $this->http->get('GetKlientasEMail', [
            'sKliKod' => $clientCode,
        ]);
    }

    /**
     * Get client types or tags. Calls GetKlientuRusisPozymius.
     *
     * @param  ClientTypeId|int  $typeId  Use ClientTypeId enum or: 22=client type, 12=tag 1, 13=tag 2, 14=tag 3
     * @return Response
     */
    public function typesAndTags(ClientTypeId|int $typeId = ClientTypeId::Type): Response
    {
        $id = $typeId instanceof ClientTypeId ? $typeId->value : $typeId;

        return $this->http->get('GetKlientuRusisPozymius', [
            'nID' => $id,
        ]);
    }

    /**
     * Get clients belonging to a specific type. Calls GetKlientusRusiesSudeti.
     *
     * @param  string  $typeCode  The client type code
     * @return Response
     */
    public function byType(string $typeCode): Response
    {
        return $this->http->get('GetKlientusRusiesSudeti', [
            'sRusiesKodas' => $typeCode,
        ]);
    }

    /**
     * Get client accounts (invoices/documents). Calls GetKlientoSaskaitas.
     *
     * @param  string|null  $clientCode  Filter by client code
     * @param  string|null  $companyCode  Filter by company registration code
     * @param  string|null  $clientGroup  Filter by client group code
     * @param  int|null  $debtType  Filter by debt type
     * @param  string|null  $journalGroup  Filter by journal group code
     * @param  string|null  $series  Filter by document series
     * @param  int|null  $operationType  Filter by operation type
     * @param  DateTimeInterface|string|null  $documentDateFrom  Document date range start
     * @param  DateTimeInterface|string|null  $documentDateTo  Document date range end
     */
    public function accounts(
        ?string $clientCode = null,
        ?string $companyCode = null,
        ?string $clientGroup = null,
        ?int $debtType = null,
        ?string $journalGroup = null,
        ?string $series = null,
        ?int $operationType = null,
        DateTimeInterface|string|null $documentDateFrom = null,
        DateTimeInterface|string|null $documentDateTo = null,
    ): Response {
        return $this->http->get('GetKlientoSaskaitas', [
            'sKlientas' => $clientCode,
            'sKlientImonesKodas' => $companyCode,
            'sKlientuGrupe' => $clientGroup,
            'nSkolosTipas' => $debtType,
            'sZurnaluGrupe' => $journalGroup,
            'sSerija' => $series,
            'nOperacijosTipas' => $operationType,
            'tDokumentoDataNuo' => $this->formatDate($documentDateFrom),
            'tDokumentoDataIki' => $this->formatDate($documentDateTo),
        ]);
    }

    /**
     * Get unpaid sales documents for a client. Calls GetNeapmoketiKliDok.
     *
     * @param  string  $clientCode  The client code
     * @return Response
     */
    public function unpaidDocuments(string $clientCode): Response
    {
        return $this->http->get('GetNeapmoketiKliDok', [
            'sKlientoKodas' => $clientCode,
        ]);
    }

    /**
     * Get unpaid purchase documents for a client. Calls GetNeapmoketiPirkKliDok.
     *
     * @param  string  $clientCode  The client code
     * @return Response
     */
    public function unpaidPurchaseDocuments(string $clientCode): Response
    {
        return $this->http->get('GetNeapmoketiPirkKliDok', [
            'sKlientoKodas' => $clientCode,
        ]);
    }

    /**
     * Get client debt condition summary. Calls GetClientDebtCondition.
     *
     * @param  string  $clientCode  The client code
     * @param  string|null  $journalGroup  Filter by journal group code
     * @return Response
     */
    public function debtCondition(string $clientCode, ?string $journalGroup = null): Response
    {
        return $this->http->get('GetClientDebtCondition', [
            'sKlientoKodas' => $clientCode,
            'sZurnaluGrupe' => $journalGroup,
        ]);
    }

    /**
     * Get settlements for a document. Calls GetAtsiskaitymaiUzDok.
     *
     * @param  string|null  $series  Document series
     * @param  string|null  $document  Document identifier
     * @param  string|null  $journal  Journal code
     * @param  int|null  $number  Document number
     * @return Response
     */
    public function settlements(
        ?string $series = null,
        ?string $document = null,
        ?string $journal = null,
        ?int $number = null,
    ): Response {
        return $this->http->get('GetAtsiskaitymaiUzDok', [
            'sSerija' => $series,
            'sDokumentas' => $document,
            'sZurnalas' => $journal,
            'nNumeris' => $number,
        ]);
    }

    /**
     * Get detailed settlements for a document. Calls GetAtsiskaitymaiUzDokDet.
     *
     * @param  string|null  $series  Document series
     * @param  string|null  $document  Document identifier
     * @param  string|null  $journal  Journal code
     * @param  int|null  $number  Document number
     * @param  int|null  $operationId  Filter by operation ID
     * @param  int|null  $operationClass  Filter by operation class
     * @return Response
     */
    public function settlementsDetailed(
        ?string $series = null,
        ?string $document = null,
        ?string $journal = null,
        ?int $number = null,
        ?int $operationId = null,
        ?int $operationClass = null,
    ): Response {
        return $this->http->get('GetAtsiskaitymaiUzDokDet', [
            'sSerija' => $series,
            'sDokumentas' => $document,
            'sZurnalas' => $journal,
            'nNumeris' => $number,
            'nOperacijosID' => $operationId,
            'nOperacijosKlase' => $operationClass,
        ]);
    }

    /**
     * Get detailed settlements with date filtering. Calls GetAtsiskaitymaiUzDokDataNuoDet.
     *
     * @param  string|null  $series  Document series
     * @param  string|null  $document  Document identifier
     * @param  string|null  $journal  Journal code
     * @param  int|null  $number  Document number
     * @param  int|null  $operationId  Filter by operation ID
     * @param  int|null  $operationClass  Filter by operation class
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     */
    public function settlementsFromDate(
        ?string $series = null,
        ?string $document = null,
        ?string $journal = null,
        ?int $number = null,
        ?int $operationId = null,
        ?int $operationClass = null,
        DateTimeInterface|string|null $createdSince = null,
        DateTimeInterface|string|null $modifiedSince = null,
    ): Response {
        return $this->http->get('GetAtsiskaitymaiUzDokDataNuoDet', [
            'sSerija' => $series,
            'sDokumentas' => $document,
            'sZurnalas' => $journal,
            'nNumeris' => $number,
            'nOperacijosID' => $operationId,
            'nOperacijosKlase' => $operationClass,
            'tSukurimoData' => $this->formatDate($createdSince),
            'tKoregavimoData' => $this->formatDate($modifiedSince),
        ]);
    }

    /**
     * Get detailed settlements using XML parameter string. Calls GetAtsiskaitymaiUzDokDataNuoDetParam.
     *
     * @param  string  $xmlParam  XML-encoded filter parameters
     * @return Response
     */
    public function settlementsFromDateParam(string $xmlParam): Response
    {
        return $this->http->get('GetAtsiskaitymaiUzDokDataNuoDetParam', [
            'sParam' => $xmlParam,
        ]);
    }

    /**
     * Create a new client. Calls InsertNewItem with Fvs.Klientas class.
     *
     * @param  array  $data  Client data (keys: sKodas, sPavadinimas, sImonesKodas, sPVMKodas, sAdresas, etc.)
     *                       If your server requires it, include sFvsImportoParametras in the data array.
     *                       This is a server-configured import handler parameter.
     */
    public function create(array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::Client->value,
            'xmlstring' => $this->jsonEncode([ItemClass::Client->value => $data]),
        ]);
    }

    /**
     * Update an existing client. Calls EditItem with Fvs.Klientas class.
     *
     * @param  array  $data  Client data with sKodas identifying the record to update.
     *                       If your server requires it, include sFvsImportoParametras in the data array.
     *                       This is a server-configured import handler parameter.
     */
    public function update(array $data): OperationResult
    {
        $code = $data['sKodas'] ?? '';

        return $this->http->postOperation('EditItem', [
            'ItemClassName' => ItemClass::Client->value,
            'sItemCode' => $code,
            'xmlstring' => $this->jsonEncode([ItemClass::Client->value => $data]),
        ]);
    }

    /**
     * Delete a client by code. Calls DeleteItem with Fvs.Klientas class.
     *
     * @param  string  $clientCode  The client code to delete
     */
    public function delete(string $clientCode): OperationResult
    {
        return $this->http->postOperation('DeleteItem', [
            'ItemClassName' => ItemClass::Client->value,
            'sItemCode' => $clientCode,
        ]);
    }

    /**
     * Get invoices related to a customer. Calls GetInvoicesRelatedToCustomer.
     *
     * @param  string  $clientCode  The client code
     * @param  int  $debtType  Debt type filter (0=all)
     * @return Response
     */
    public function invoicesRelatedToCustomer(string $clientCode, int $debtType = 0): Response
    {
        return $this->http->post('GetInvoicesRelatedToCustomer', [
            'sKlientoKodas' => $clientCode,
            'nDebtType' => $debtType,
        ]);
    }
}
