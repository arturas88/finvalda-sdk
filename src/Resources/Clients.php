<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Enums\ItemClass;
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
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function list(
        ?string $clientCode = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientusSet', [
            'sKliKod' => $clientCode,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
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
     * Get all clients with optional date filters. Calls GetKlientus.
     *
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function all(
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        return $this->http->get('GetKlientus', [
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
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
     * @param  int  $typeId  22=client type, 12=tag 1, 13=tag 2, 14=tag 3
     * @return Response
     */
    public function typesAndTags(int $typeId = 22): Response
    {
        return $this->http->get('GetKlientuRusisPozymius', [
            'nID' => $typeId,
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
     * @param  string|null  $documentDateFrom  Date in Y-m-d format, document date range start
     * @param  string|null  $documentDateTo  Date in Y-m-d format, document date range end
     * @return Response
     */
    public function accounts(
        ?string $clientCode = null,
        ?string $companyCode = null,
        ?string $clientGroup = null,
        ?int $debtType = null,
        ?string $journalGroup = null,
        ?string $series = null,
        ?int $operationType = null,
        ?string $documentDateFrom = null,
        ?string $documentDateTo = null,
    ): Response {
        return $this->http->get('GetKlientoSaskaitas', [
            'sKlientas' => $clientCode,
            'sKlientImonesKodas' => $companyCode,
            'sKlientuGrupe' => $clientGroup,
            'nSkolosTipas' => $debtType,
            'sZurnaluGrupe' => $journalGroup,
            'sSerija' => $series,
            'nOperacijosTipas' => $operationType,
            'tDokumentoDataNuo' => $documentDateFrom,
            'tDokumentoDataIki' => $documentDateTo,
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
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @return Response
     */
    public function settlementsFromDate(
        ?string $series = null,
        ?string $document = null,
        ?string $journal = null,
        ?int $number = null,
        ?int $operationId = null,
        ?int $operationClass = null,
        ?string $createdSince = null,
        ?string $modifiedSince = null,
    ): Response {
        return $this->http->get('GetAtsiskaitymaiUzDokDataNuoDet', [
            'sSerija' => $series,
            'sDokumentas' => $document,
            'sZurnalas' => $journal,
            'nNumeris' => $number,
            'nOperacijosID' => $operationId,
            'nOperacijosKlase' => $operationClass,
            'tSukurimoData' => $createdSince,
            'tKoregavimoData' => $modifiedSince,
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
     * @param  array  $data  Client data (keys: Kodas, Pavadinimas, ImonesKodas, PVMKodas, Adresas, etc.)
     * @return OperationResult
     */
    public function create(array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => ItemClass::Client->value,
            'xmlstring' => $this->jsonEncode($data),
        ]);
    }

    /**
     * Update an existing client. Calls EditItem with Fvs.Klientas class.
     *
     * @param  array  $data  Client data with Kodas identifying the record to update
     * @return OperationResult
     */
    public function update(array $data): OperationResult
    {
        return $this->http->postOperation('EditItem', [
            'ItemClassName' => ItemClass::Client->value,
            'xmlstring' => $this->jsonEncode($data),
        ]);
    }

    /**
     * Delete a client by code. Calls DeleteItem with Fvs.Klientas class.
     *
     * @param  string  $clientCode  The client code to delete
     * @return OperationResult
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
