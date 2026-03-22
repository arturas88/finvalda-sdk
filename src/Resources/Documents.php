<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Enums\DocumentEntityType;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;

/**
 * Document upload, attachment, and management operations.
 */
final class Documents extends Resource
{
    /**
     * Upload a document to Finvalda. Calls InsertDocument.
     *
     * @param  string  $filename  The filename to store the document as
     * @param  string  $hexContent  Hex-encoded binary file content
     * @return OperationResult
     */
    public function upload(string $filename, string $hexContent): OperationResult
    {
        return $this->http->postOperation('InsertDocument', [
            'sFileName' => $filename,
            'sFileContent' => $hexContent,
        ]);
    }

    /**
     * Upload a document from a local file path. Reads the file and hex-encodes it automatically.
     *
     * @param  string  $filename  The filename to store the document as in Finvalda
     * @param  string  $filePath  Absolute path to the local file to upload
     * @return OperationResult
     *
     * @throws \Finvalda\Exceptions\FinvaldaException If the file is not readable
     */
    public function uploadFile(string $filename, string $filePath): OperationResult
    {
        if (! is_readable($filePath)) {
            throw new \Finvalda\Exceptions\FinvaldaException("File not readable: {$filePath}");
        }

        $content = file_get_contents($filePath);

        if ($content === false) {
            throw new \Finvalda\Exceptions\FinvaldaException("Failed to read file: {$filePath}");
        }

        return $this->upload($filename, bin2hex($content));
    }

    /**
     * Delete a document by filename. Calls DeleteDocument.
     *
     * @param  string  $filename  The filename of the document to delete
     * @return OperationResult
     */
    public function delete(string $filename): OperationResult
    {
        return $this->http->postOperation('DeleteDocument', [
            'sFileName' => $filename,
        ]);
    }

    /**
     * Attach a document to an entity (client, product, operation, etc.). Calls AttachDocument.
     *
     * @param  DocumentEntityType  $entityType  The type of entity to attach to
     * @param  string  $entityCode  The entity code (client code, product code, etc.)
     * @param  string  $filename  The filename of the previously uploaded document
     * @param  string|null  $journal  Journal code (required for operation entities)
     * @param  int|null  $number  Operation number (required for operation entities)
     * @return OperationResult
     */
    public function attach(
        DocumentEntityType $entityType,
        string $entityCode,
        string $filename,
        ?string $journal = null,
        ?int $number = null,
    ): OperationResult {
        return $this->http->postOperation('AttachDocument', [
            'nEntityType' => $entityType->value,
            'sEntityCode' => $entityCode,
            'sFileName' => $filename,
            'sZurnalas' => $journal,
            'nNumeris' => $number,
        ]);
    }

    /**
     * Get documents attached to an entity. Calls GetAttachedDocuments.
     *
     * @param  DocumentEntityType  $entityType  The type of entity to query
     * @param  string  $entityCode  The entity code (client code, product code, etc.)
     * @param  string|null  $journal  Journal code (for operation entities)
     * @param  int|null  $number  Operation number (for operation entities)
     * @return Response
     */
    public function attached(
        DocumentEntityType $entityType,
        string $entityCode,
        ?string $journal = null,
        ?int $number = null,
    ): Response {
        return $this->http->get('GetAttachedDocuments', [
            'nEntityType' => $entityType->value,
            'sEntityCode' => $entityCode,
            'sZurnalas' => $journal,
            'nNumeris' => $number,
        ]);
    }
}
