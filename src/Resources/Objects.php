<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use DateTimeInterface;
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
     * @param  DateTimeInterface|string|null  $modifiedSince  Return records modified since this date
     * @param  DateTimeInterface|string|null  $createdSince  Return records created since this date
     */
    public function list(
        int $level,
        ?string $objectCode = null,
        DateTimeInterface|string|null $modifiedSince = null,
        DateTimeInterface|string|null $createdSince = null,
    ): Response {
        $this->validateLevel($level);

        return $this->http->get("GetObjektai{$level}Set", [
            "sObj{$level}Kod" => $objectCode,
            'tKoregavimoData' => $this->formatDate($modifiedSince),
            'tSukurimoData' => $this->formatDate($createdSince),
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
     * @param  array  $data  Object data (keys: sKodas, sPavadinimas, etc.)
     *                       If your server requires it, include sFvsImportoParametras in the data array.
     *                       This is a server-configured import handler parameter.
     */
    public function create(int $level, array $data): OperationResult
    {
        $this->validateLevel($level);
        $className = self::LEVEL_CLASS_MAP[$level]->value;

        return $this->http->postOperation('InsertNewItem', [
            'ItemClassName' => $className,
            'xmlString' => $this->jsonEncode([$className => $data]),
        ]);
    }

    /**
     * Update an existing object at the given level. Calls EditItem with the corresponding object class.
     *
     * @param  int  $level  Object level (1-6)
     * @param  array  $data  Object data with sKodas identifying the record to update.
     *                       If your server requires it, include sFvsImportoParametras in the data array.
     *                       This is a server-configured import handler parameter.
     */
    public function update(int $level, array $data): OperationResult
    {
        $this->validateLevel($level);
        $className = self::LEVEL_CLASS_MAP[$level]->value;
        $code = $data['sKodas'] ?? '';

        return $this->http->postOperation('EditItem', [
            'ItemClassName' => $className,
            'sItemCode' => $code,
            'xmlString' => $this->jsonEncode([$className => $data]),
        ]);
    }

    private function validateLevel(int $level): void
    {
        if ($level < 1 || $level > 6) {
            throw new \InvalidArgumentException("Object level must be between 1 and 6, got {$level}");
        }
    }
}
