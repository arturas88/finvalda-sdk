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
     * @return OperationResult
     */
    public function create(OperationClass $class, array|string $data): OperationResult
    {
        $body = is_array($data) ? $this->jsonEncode($data) : $data;

        return $this->http->postOperation('InsertNewOperation', [
            'ItemClassName' => $class->value,
        ], $body);
    }

    /**
     * Delete an operation by journal and number. Calls DeleteOperation.
     *
     * @param  DeleteOperationClass  $class  The operation class for deletion
     * @param  string  $journal  Journal code
     * @param  int  $number  Operation number within the journal
     * @return OperationResult
     */
    public function delete(DeleteOperationClass $class, string $journal, int $number): OperationResult
    {
        return $this->http->postOperation('DeleteOperation', [
            'ItemClassName' => $class->value,
            'sZurnalas' => $journal,
            'nNumeris' => $number,
        ]);
    }

    /**
     * Update an existing operation. Calls UpdateOperation.
     *
     * @param  UpdateOperationClass  $class  The operation class for update
     * @param  array|string  $data  Operation data as array or pre-encoded JSON string
     * @return OperationResult
     */
    public function update(UpdateOperationClass $class, array|string $data): OperationResult
    {
        $body = is_array($data) ? $this->jsonEncode($data) : $data;

        return $this->http->postOperation('UpdateOperation', [
            'ItemClassName' => $class->value,
        ], $body);
    }

    /**
     * Read operations with query string filtering. Calls GetOperations.
     *
     * @param  OpClass  $class  The operation class to query (e.g., Sales, Purchases, SalesDet)
     * @param  array  $filters  Additional filter parameters (keys: Journal, DateFrom, DateTo, Number, etc.)
     * @return Response
     */
    public function get(OpClass $class, array $filters = []): Response
    {
        $params = array_merge(['OpClass' => $class->value], $filters);

        return $this->http->get('GetOperations', $params);
    }

    /**
     * Read operations with JSON body filters. Calls GetOperations via POST.
     *
     * @param  OpClass  $class  The operation class to query (e.g., Sales, Purchases, SalesDet)
     * @param  array  $filters  Additional filter parameters (keys: Journal, DateFrom, DateTo, Number, etc.)
     * @return Response
     */
    public function query(OpClass $class, array $filters = []): Response
    {
        $data = array_merge(['OpClass' => $class->value], $filters);

        return $this->http->postJson('GetOperations', $data);
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
        return $this->http->postOperation('LockOperation', [
            'sZurnalas' => $journal,
            'nNumeris' => $number,
            'sParametras' => $parameter,
        ]);
    }

    /**
     * Unlock a previously locked operation. Calls UnLockOperation.
     *
     * @param  string  $journal  Journal code
     * @param  int  $number  Operation number within the journal
     * @param  string|null  $parameter  Optional unlock parameter
     * @return OperationResult
     */
    public function unlock(string $journal, int $number, ?string $parameter = null): OperationResult
    {
        return $this->http->postOperation('UnLockOperation', [
            'sZurnalas' => $journal,
            'nNumeris' => $number,
            'sParametras' => $parameter,
        ]);
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
        return $this->http->post('IsOperationLocked', [
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
     * @param  array|string  $data  Operation identification and target journal data
     * @return OperationResult
     */
    public function changeJournal(array|string $data): OperationResult
    {
        $body = is_array($data) ? $this->jsonEncode($data) : $data;

        return $this->http->postOperation('ChangeJournal', [], $body);
    }

    /**
     * Copy/duplicate an existing operation. Calls CopyOperation.
     *
     * @param  array|string  $data  Source operation identification and copy parameters
     * @return OperationResult
     */
    public function copy(array|string $data): OperationResult
    {
        $body = is_array($data) ? $this->jsonEncode($data) : $data;

        return $this->http->postOperation('CopyOperation', [], $body);
    }
}
