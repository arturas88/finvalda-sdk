<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Enums\DeleteOperationClass;
use Finvalda\Enums\OpClass;
use Finvalda\Enums\OperationClass;
use Finvalda\Enums\UpdateOperationClass;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;

/**
 * CRUD operations for sales, purchases, transfers, payments, and other document operations.
 */
final class Operations extends Resource
{
    /**
     * Create a new operation (sale, purchase, transfer, etc.). Calls InsertNewOperation.
     *
     * @param  OperationClass  $class  The operation class (e.g., Sale, Purchase, InternalTransfer)
     * @param  array|string  $data  Operation data as array or pre-encoded JSON string
     * @param  string  $parameter  Server-configured journal/import parameter (sParametras).
     *                             This value is defined in your Finvalda server configuration
     *                             and tells the server which journal config to use.
     */
    public function create(OperationClass $class, array|string $data, string $parameter): OperationResult
    {
        $body = is_array($data) ? $this->jsonEncode($data) : $data;

        return $this->http->postOperation('InsertNewOperation', [
            'ItemClassName' => $class->value,
            'sParametras' => $parameter,
        ], $body);
    }

    /**
     * Delete an operation by journal and number. Calls DeleteOperation.
     *
     * @param  DeleteOperationClass  $class  The operation class for deletion
     * @param  string  $journal  Journal code
     * @param  int  $number  Operation number within the journal
     * @param  string  $parameter  Server-configured journal/import parameter (sParametras).
     *                             This value is defined in your Finvalda server configuration.
     */
    public function delete(DeleteOperationClass $class, string $journal, int $number, string $parameter): OperationResult
    {
        $body = $this->jsonEncode([$class->value => [
            'sZurnalas' => $journal,
            'nNumeris' => $number,
        ]]);

        return $this->http->postOperation('DeleteOperation', [
            'ItemClassName' => $class->value,
            'sParametras' => $parameter,
        ], $body);
    }

    /**
     * Update an existing operation. Calls UpdateOperation.
     *
     * @param  UpdateOperationClass  $class  The operation class for update
     * @param  array|string  $data  Operation data as array or pre-encoded JSON string
     * @param  string  $parameter  Server-configured journal/import parameter (sParametras).
     *                             This value is defined in your Finvalda server configuration.
     */
    public function update(UpdateOperationClass $class, array|string $data, string $parameter): OperationResult
    {
        $body = is_array($data) ? $this->jsonEncode($data) : $data;

        return $this->http->postOperation('UpdateOperation', [
            'ItemClassName' => $class->value,
            'sParametras' => $parameter,
        ], $body);
    }

    /**
     * Read operations via GET with JSON-encoded opReadParams. Calls GetOperations.
     *
     * The Pure service expects opReadParams as a single xml/json string query
     * parameter, not flattened query params.
     *
     * @param  OpClass  $class  The operation class to query
     * @param  array<string, mixed>  $filters  Additional opReadParams keys (fullOp, filter, columns, columnsDet)
     *
     * @throws \JsonException
     */
    public function get(OpClass $class, array $filters = []): Response
    {
        $opReadParams = array_merge(['OpClass' => $class->value], $filters);

        return $this->http->get('GetOperations', [
            'opReadParams' => $this->jsonEncode($opReadParams),
        ]);
    }

    /**
     * Read operations with JSON body filters. Calls GetOperations via POST.
     *
     * @param  OpClass  $class  The operation class to query (e.g., Sales, Purchases, SalesDet)
     * @param  array  $filters  Additional filter parameters (keys: fullOp, filter, columns, columnsDet)
     * @return Response
     */
    public function query(OpClass $class, array $filters = []): Response
    {
        $opReadParams = array_merge(['OpClass' => $class->value], $filters);

        return $this->http->postJson('GetOperations', [
            'opReadParams' => $opReadParams,
        ]);
    }

    /**
     * Lock an operation to prevent editing by other users. Calls LockOperation.
     *
     * @param  string  $journal  Journal code
     * @param  int  $number  Operation number within the journal
     * @param  string|null  $parameter  Optional lock parameter
     * @return OperationResult
     */
    public function lock(string $journal, int $number, ?string $parameter = null): OperationResult
    {
        return $this->http->postOperationJson('LockOperation', array_filter([
            'sZurnalas' => $journal,
            'nNumeris' => $number,
            'sParametras' => $parameter,
        ], fn ($v) => $v !== null));
    }

    /**
     * Unlock a previously locked operation. Calls UnLockOperation.
     *
     * @param  string  $journal  Journal code
     * @param  int  $number  Operation number within the journal
     * @param  string|null  $parameter  Optional unlock parameter
     * @param  string|null  $newJournal  Optional new journal code to move the operation to
     * @return OperationResult
     */
    public function unlock(string $journal, int $number, ?string $parameter = null, ?string $newJournal = null): OperationResult
    {
        return $this->http->postOperationJson('UnLockOperation', array_filter([
            'sZurnalas' => $journal,
            'nNumeris' => $number,
            'sParametras' => $parameter,
            'sZurnalasNaujas' => $newJournal,
        ], fn ($v) => $v !== null));
    }

    /**
     * Check if an operation is locked. Calls IsOperationLocked.
     *
     * @param  string  $journal  Journal code
     * @param  int  $number  Operation number within the journal
     * @return Response  Returns 0=unlocked, 1=locked by user, 2=locked by admin
     */
    public function isLocked(string $journal, int $number): Response
    {
        return $this->http->postJson('IsOperationLocked', [
            'sZurnalas' => $journal,
            'nNumeris' => $number,
        ]);
    }

    /**
     * Get activity report grouped by analytical objects. Calls GetVeiklaPagalObjektus.
     *
     * @param  array  $params  Report parameters (keys: DateFrom, DateTo, Objects, etc.)
     * @return Response
     */
    public function activityByObjects(array $params): Response
    {
        return $this->http->postJson('GetVeiklaPagalObjektus', $params);
    }

    /**
     * Change the journal of an existing operation. Calls ChangeJournal.
     *
     * @param  array<string, mixed>|string  $data  Keys: sJournal, nOpNumber, sJournalNew
     *
     * @throws \JsonException
     */
    public function changeJournal(array|string $data): OperationResult
    {
        return $this->http->postOperationJson('ChangeJournal', $this->decodeJsonInput($data));
    }

    /**
     * Copy/duplicate an existing operation. Calls CopyOperation.
     *
     * @param  array<string, mixed>|string  $data  Keys: sParameter, sJournal, nOpNumber, sJournalNew, bDeleteSourceOp, bKeepDocument, sNewDocument, sNewSeries, nCopyDocDate
     *
     * @throws \JsonException
     */
    public function copy(array|string $data): OperationResult
    {
        return $this->http->postOperationJson('CopyOperation', [
            'input' => $this->decodeJsonInput($data),
        ]);
    }

    /**
     * @param  array<string, mixed>|string  $data
     * @return array<string, mixed>
     *
     * @throws \JsonException
     */
    private function decodeJsonInput(array|string $data): array
    {
        if (is_array($data)) {
            return $data;
        }

        $decoded = json_decode($data, true, 512, JSON_THROW_ON_ERROR);

        if (! is_array($decoded)) {
            throw new \JsonException('JSON input must decode to an object/array');
        }

        return $decoded;
    }
}
