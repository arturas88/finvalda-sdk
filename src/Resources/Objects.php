<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Enums\ItemClass;
use Finvalda\Responses\OperationResult;
use Finvalda\Responses\Response;

/**
 * Analytical object operations (6 hierarchical levels).
 */
final class Objects extends Resource
{
    private const LEVEL_CLASS_MAP = [
        1 => ItemClass::Object1,
        2 => ItemClass::Object2,
        3 => ItemClass::Object3,
        4 => ItemClass::Object4,
        5 => ItemClass::Object5,
        6 => ItemClass::Object6,
    ];

    /**
     * Get objects at a given level as a dataset. Calls GetObjektai{level}Set.
     *
     * @param  int  $level  Object level (1-6)
     * @param  string|null  $objectCode  Filter by object code
     * @param  string|null  $modifiedSince  Date in Y-m-d format, return records modified since
     * @param  string|null  $createdSince  Date in Y-m-d format, return records created since
     * @return Response
     */
    public function list(
        int $level,
        ?string $objectCode = null,
        ?string $modifiedSince = null,
        ?string $createdSince = null,
    ): Response {
        $this->validateLevel($level);

        return $this->http->get("GetObjektai{$level}Set", [
            "sObj{$level}Kod" => $objectCode,
            'tKoregavimoData' => $modifiedSince,
            'tSukurimoData' => $createdSince,
        ]);
    }

    /**
     * Get a single object by level and code. Calls GetObjektas{level}.
     *
     * @param  int  $level  Object level (1-6)
     * @param  string  $objectCode  The object code
     * @return Response
     */
    public function get(int $level, string $objectCode): Response
    {
        $this->validateLevel($level);

        return $this->http->get("GetObjektas{$level}", [
            "sObj{$level}Kod" => $objectCode,
        ]);
    }

    /**
     * Create a new object at the given level. Calls InsertNewItem with the corresponding object class.
     *
     * @param  int  $level  Object level (1-6)
     * @param  array  $data  Object data (keys: Kodas, Pavadinimas, etc.)
     * @return OperationResult
     */
    public function create(int $level, array $data): OperationResult
    {
        $this->validateLevel($level);

        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => self::LEVEL_CLASS_MAP[$level]->value,
            'xmlstring' => $this->jsonEncode($data),
        ]);
    }

    /**
     * Update an existing object at the given level. Calls EditItem with the corresponding object class.
     *
     * @param  int  $level  Object level (1-6)
     * @param  array  $data  Object data with Kodas identifying the record to update
     * @return OperationResult
     */
    public function update(int $level, array $data): OperationResult
    {
        $this->validateLevel($level);

        return $this->http->postOperation('EditItem', [
            'ItemClassName' => self::LEVEL_CLASS_MAP[$level]->value,
            'xmlstring' => $this->jsonEncode($data),
        ]);
    }

    private function validateLevel(int $level): void
    {
        if ($level < 1 || $level > 6) {
            throw new \InvalidArgumentException("Object level must be between 1 and 6, got {$level}");
        }
    }
}
