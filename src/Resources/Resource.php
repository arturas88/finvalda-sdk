<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Concerns\FormatsDate;
use Finvalda\Enums\ItemClass;
use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Exceptions\OperationNotSupportedException;
use Finvalda\HttpClient;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;
use InvalidArgumentException;

abstract class Resource
{
    use FormatsDate;

    public function __construct(
        protected readonly HttpClient $http,
    ) {}

    /**
     * Extract a single-entity payload from a response.
     *
     * Single-entity reads (GetPreke, GetKlientas, GetPaslauga) wrap the
     * entity in its item class name: {"Fvs.Preke": {...}} when found,
     * {"Fvs.Preke": null} when not found. Also tolerates unwrapped and
     * single-element list shapes.
     *
     * @return array|null The entity fields, or null when the response
     *                    carries no entity (not found).
     *
     * @throws FinvaldaException when the request failed — a failure is not "not found"
     */
    protected function extractEntity(Response $response, ItemClass $itemClass, string $endpoint): ?array
    {
        $data = $this->requireSuccess($response, $endpoint)->data;

        if (array_key_exists($itemClass->value, $data)) {
            $data = $data[$itemClass->value];
        }

        if (is_array($data) && is_array($data[0] ?? null)) {
            $data = $data[0];
        }

        return is_array($data) && $data !== [] ? $data : null;
    }

    /**
     * Return the response, or throw when the read failed.
     *
     * Derived reads (find, collect, cached dictionaries) must not turn a
     * failure into "no rows": a caller would act on the empty answer.
     *
     * @throws FinvaldaException
     */
    protected function requireSuccess(Response $response, string $endpoint): Response
    {
        if ($response->failed()) {
            throw new FinvaldaException("{$endpoint} failed: " . ($response->error ?? 'Unknown error'));
        }

        return $response;
    }

    /**
     * Create a description record. Calls InsertNewItem.
     *
     * @param  array<string, mixed>  $data  Fields; include sFvsImportoParametras if the server requires it
     */
    protected function insertItem(ItemClass $itemClass, array $data): OperationResult
    {
        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => $itemClass->value,
            'xmlstring' => $this->jsonEncode([$itemClass->value => $data]),
        ]);
    }

    /**
     * Update a description record, identified by its sKodas. Calls EditItem.
     *
     * @param  array<string, mixed>  $data  Fields, including the sKodas of the record to update
     *
     * @throws InvalidArgumentException when sKodas is missing or empty
     */
    protected function editItem(ItemClass $itemClass, array $data): OperationResult
    {
        $code = $data['sKodas'] ?? null;

        if (! is_string($code) || $code === '') {
            throw new InvalidArgumentException(
                "Updating {$itemClass->value} needs the record's code in sKodas; EditItem identifies the record by it."
            );
        }

        return $this->http->postOperation('EditItem', [
            'ItemClassName' => $itemClass->value,
            'sItemCode' => $code,
            'xmlstring' => $this->jsonEncode([$itemClass->value => $data]),
        ]);
    }

    /**
     * Delete a description record by code. Calls DeleteItem.
     *
     * `DeleteItem` is only available on FvsServicePure builds that expose it;
     * older builds answer 404. When that happens we surface a clear
     * OperationNotSupportedException rather than an opaque transport error.
     *
     * @throws OperationNotSupportedException when the server build lacks DeleteItem
     */
    protected function deleteItem(ItemClass $itemClass, string $code): OperationResult
    {
        try {
            return $this->http->postOperationJson('DeleteItem', [
                'input' => [
                    'ItemClassName' => $itemClass->value,
                    'Code' => $code,
                ],
            ]);
        } catch (FinvaldaException $e) {
            if ($e->getCode() === 404) {
                throw new OperationNotSupportedException(
                    'DeleteItem is not supported by this Finvalda server build (the '
                    . 'FvsServicePure endpoint returned 404). Create (InsertNewItem) and '
                    . 'update (EditItem) are available; deleting requires a newer Pure '
                    . 'build that exposes DeleteItem.',
                    'DeleteItem',
                );
            }

            throw $e;
        }
    }

    /**
     * Safely encode SDK-owned outbound data to JSON, throwing on failure.
     *
     * @throws \JsonException
     */
    protected function jsonEncode(mixed $data): string
    {
        return $this->http->encodeJson($data);
    }
}
