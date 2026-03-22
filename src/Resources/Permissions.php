<?php

declare(strict_types=1);

namespace Finvalda\Resources;

use Finvalda\Responses\Response;

/**
 * User permission queries for entity-level access control.
 */
final class Permissions extends Resource
{
    /**
     * Get entities the authenticated user has permission to access. Calls GetUserPermissions.
     *
     * @param  int  $permissionClass  65=warehouses, 6=clients, 51=operation types, 81=operation journals
     * @return Response
     */
    public function get(int $permissionClass): Response
    {
        return $this->http->get('GetUserPermissions', [
            'nPermClass' => $permissionClass,
        ]);
    }

    /**
     * Get warehouses the user has permission to access.
     *
     * @return Response
     */
    public function warehouses(): Response
    {
        return $this->get(65);
    }

    /**
     * Get clients the user has permission to access.
     *
     * @return Response
     */
    public function clients(): Response
    {
        return $this->get(6);
    }

    /**
     * Get operation types the user has permission to access.
     *
     * @return Response
     */
    public function operationTypes(): Response
    {
        return $this->get(51);
    }

    /**
     * Get operation journals the user has permission to access.
     *
     * @return Response
     */
    public function operationJournals(): Response
    {
        return $this->get(81);
    }
}
