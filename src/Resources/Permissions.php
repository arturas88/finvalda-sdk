<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Exceptions\FinvaldaException;
use Finvalda\Responses\Response;
use LogicException;

/**
 * User permission queries.
 *
 * GetUserPermissions takes only the Finvalda user (finUser) and answers every
 * permission class at once, under `perrmissions` (the API's spelling): one
 * record per class, each with its `permittedEntities` as {id1, id2} pairs.
 */
final class Permissions extends Resource
{
    public const WAREHOUSES = 65;

    public const CLIENTS = 6;

    public const OPERATION_TYPES = 51;

    public const OPERATION_JOURNALS = 81;

    /**
     * Get every permission class for a Finvalda user. Calls GetUserPermissions.
     *
     * @param  string|null  $finUser  Finvalda user name (not the WS user)
     */
    public function forUser(?string $finUser = null): Response
    {
        return $this->http->get('GetUserPermissions', [
            'finUser' => $finUser,
        ]);
    }

    /**
     * Retired: v3's get(int $permissionClass) took a class; the WS takes only
     * the user. Reusing the name would send the class number as the user name.
     */
    public function get(mixed ...$arguments): never
    {
        throw new LogicException(
            'Permissions::get() was removed in v4: GetUserPermissions takes only the Finvalda user, so '
            . 'get($permissionClass) cannot work. Use forUser($finUser) for every class, or '
            . 'entities($permissionClass, $finUser) / warehouses() / clients() for one class.'
        );
    }

    /**
     * The entities a user may access in one permission class.
     *
     * @param  int  $permissionClass  One of the class constants (65, 6, 51, 81)
     * @return list<array{id1: ?string, id2: ?string}>
     *
     * @throws FinvaldaException when the request or the lookup failed (e.g. unknown finUser)
     */
    public function entities(int $permissionClass, ?string $finUser = null): array
    {
        $raw = $this->requireSuccess($this->forUser($finUser), 'GetUserPermissions')->raw;
        $result = $raw['results'] ?? $raw['result'] ?? [];
        $result = is_array($result) ? $result : [];

        if ((int) ($result['errorCode'] ?? 0) !== 0) {
            $text = $result['errorText'] ?? null;

            throw new FinvaldaException('GetUserPermissions failed: ' . (is_string($text) && $text !== '' ? $text : 'error code ' . $result['errorCode']));
        }

        $entities = [];

        foreach ($result['perrmissions'] ?? [] as $record) {
            if (! is_array($record) || (int) ($record['perrmisionClass'] ?? -1) !== $permissionClass) {
                continue;
            }

            foreach ($record['permittedEntities'] ?? [] as $entity) {
                if (is_array($entity)) {
                    $entities[] = ['id1' => $entity['id1'] ?? null, 'id2' => $entity['id2'] ?? null];
                }
            }
        }

        return $entities;
    }

    /**
     * Warehouses the user may access: id1 = warehouse code.
     *
     * @return list<array{id1: ?string, id2: ?string}>
     */
    public function warehouses(?string $finUser = null): array
    {
        return $this->entities(self::WAREHOUSES, $finUser);
    }

    /**
     * Clients the user may access: id1 = client code.
     *
     * @return list<array{id1: ?string, id2: ?string}>
     */
    public function clients(?string $finUser = null): array
    {
        return $this->entities(self::CLIENTS, $finUser);
    }

    /**
     * Operation types the user may access: id1 = operation class, id2 = type code.
     *
     * @return list<array{id1: ?string, id2: ?string}>
     */
    public function operationTypes(?string $finUser = null): array
    {
        return $this->entities(self::OPERATION_TYPES, $finUser);
    }

    /**
     * Operation journals the user may access: id1 = operation class, id2 = journal code.
     *
     * @return list<array{id1: ?string, id2: ?string}>
     */
    public function operationJournals(?string $finUser = null): array
    {
        return $this->entities(self::OPERATION_JOURNALS, $finUser);
    }
}
