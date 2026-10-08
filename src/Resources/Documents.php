<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
use Finvalda\Enums\DocumentEntityType;
use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;

/**
 * Document upload, attachment, and management operations.
 *
 * The wire shapes follow the PURE examples in the API document (§3.80–3.83),
 * which are captured requests: InsertDocument posts an `inParams` object, and
 * GetAttachedDocument is a GET with flat query parameters. AttachDocument's
 * example is a GET too, but the Pure service takes GET or POST with the same
 * parameter names, and every write here is a POST through postWrite() so the
 * transport never retries it. File bytes travel hex-encoded in both directions.
 */
final class Documents extends Resource
{
    /**
     * Upload a document to Finvalda. Calls InsertDocument.
     *
     * @param  string  $filename  File name with extension
     * @param  string  $hexContent  Hex-encoded binary file content
     * @param  string|null  $description  fileDescription
     * @param  string|null  $registrationNumber  regNr
     * @param  DateTimeInterface|string|null  $compositionDate  compositionDate (sent as {year, month, day})
     * @param  string|null  $searchPhrase  searchPhrase
     * @param  list<string>  $info  Up to three info strings
     * @param  string|null  $finUser  Finvalda user (not the WS user) the upload is made as
     */
    public function upload(
        string $filename,
        string $hexContent,
        ?string $description = null,
        ?string $registrationNumber = null,
        DateTimeInterface|string|null $compositionDate = null,
        ?string $searchPhrase = null,
        array $info = [],
        ?string $finUser = null,
    ): OperationResult {
        $date = $this->formatDate($compositionDate);

        $inParams = array_filter([
            'fileName' => $filename,
            'fileDescription' => $description,
            'regNr' => $registrationNumber,
            'compositionDate' => $date === null ? null : array_combine(
                ['year', 'month', 'day'],
                array_map('intval', explode('-', $date)),
            ),
            'searchPhrase' => $searchPhrase,
            'info' => $info === [] ? null : $info,
            'content' => $hexContent,
            'finUser' => $finUser,
        ], fn ($value) => $value !== null);

        return $this->toOperationResult(
            $this->http->postWrite('InsertDocument', ['inParams' => $inParams]),
        );
    }

    /**
     * Upload a document from a local file path. Reads the file and hex-encodes it automatically.
     *
     * @param  string  $filename  The filename to store the document as in Finvalda
     * @param  string  $filePath  Absolute path to the local file to upload
     *
     * @throws FinvaldaException If the file is not readable
     */
    public function uploadFile(string $filename, string $filePath): OperationResult
    {
        if (! is_readable($filePath)) {
            throw new FinvaldaException("File not readable: {$filePath}");
        }

        $content = file_get_contents($filePath);

        if ($content === false) {
            throw new FinvaldaException("Failed to read file: {$filePath}");
        }

        return $this->upload($filename, bin2hex($content));
    }

    /**
     * Delete a document by file name (with extension). Calls DeleteDocument.
     */
    public function delete(string $filename): OperationResult
    {
        return $this->toOperationResult(
            $this->http->postWrite('DeleteDocument', ['fileName' => $filename]),
        );
    }

    /**
     * Attach a previously uploaded document to an entity. Calls AttachDocument.
     *
     * Entities are identified by up to two ids: a description by its code (an
     * address card by client code + address code), an operation by journal +
     * operation number — e.g. attach(DocumentEntityType::Sale, 'PARD', 'a.pdf', 42).
     *
     * @param  string  $id1  Entity code, or the journal for an operation
     * @param  string  $filename  The uploaded document's file name
     * @param  string|int|null  $id2  Second code, or the operation number
     * @param  string|null  $finUser  Finvalda user (not the WS user) the attachment is made as
     */
    public function attach(
        DocumentEntityType $entityType,
        string $id1,
        string $filename,
        string|int|null $id2 = null,
        ?string $finUser = null,
    ): OperationResult {
        return $this->toOperationResult($this->http->postWrite('AttachDocument', array_filter([
            'entityType' => $entityType->value,
            'id1' => $id1,
            'id2' => $id2 === null ? null : (string) $id2,
            'documentId' => $filename,
            'finUser' => $finUser,
        ], fn ($value) => $value !== null)));
    }

    /**
     * Get the documents attached to one entity. Calls GetAttachedDocument.
     *
     * The PURE variant (singular, unlike the REST/SOAP GetAttachedDocuments)
     * reads one entity per call. The files arrive hex-encoded under
     * `$response->raw['result']['enitityDocs'][n]['docs'][m]` as
     * `{name, data}` — `enitityDocs` is the API's own spelling.
     *
     * @param  string  $id1  Entity code, or the journal for an operation
     * @param  string|int|null  $id2  Second code, or the operation number
     */
    public function attached(DocumentEntityType $entityType, string $id1, string|int|null $id2 = null): Response
    {
        return $this->http->get('GetAttachedDocument', [
            'entityType' => $entityType->value,
            'id1' => $id1,
            'id2' => $id2 === null ? null : (string) $id2,
        ]);
    }

    /**
     * Fold the document endpoints' `{AccessResult, error, result: {errorCode,
     * errorText}}` envelope into an OperationResult. The spec names the output
     * `results`; the live server answers `result`; both are read. A request can pass the
     * access check and still fail inside `result` (unknown finUser, file
     * already attached).
     */
    private function toOperationResult(Response $response): OperationResult
    {
        $result = $response->raw['results'] ?? $response->raw['result'] ?? $response->raw['AttachDocumentOut'] ?? [];
        $result = is_array($result) ? $result : [];

        $errorCode = (int) ($result['errorCode'] ?? 0);
        $errorText = is_string($result['errorText'] ?? null) && $result['errorText'] !== ''
            ? $result['errorText']
            : null;

        if ($response->failed() || $response->error !== null || $errorCode !== 0) {
            return new OperationResult(
                success: false,
                error: $errorText ?? $response->error ?? 'Unknown error (AccessResult: ' . $response->accessResult->value . ')',
                errorCode: $errorCode !== 0 ? $errorCode : null,
            );
        }

        return new OperationResult(success: true);
    }
}
