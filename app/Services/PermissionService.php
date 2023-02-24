<?php

namespace App\Services;

use App\Traits\GuzzleRequest;

class PermissionService
{
    use GuzzleRequest;

    public function __construct()
    {
        //
    }

    /**
     * get permissions
     *
     * @return array
     */

    public function all(): array
    {
        $permissions = $this->makeRequest('GET', config('account-service.url.permission.list'), true);
        if (!empty($permissions) && $permissions->code == 200) {
            return (array)$permissions->data;
        }
        return [];
    }

    /**
     * create permission by permissionParams
     *
     * @param array $permissionParams
     * @return array
     */

    public function create(array $permissionParams): array
    {
        $permission = $this->makeRequest('POST', config('account-service.url.permission.store'), true, [
            'app_id' => !empty($permissionParams['app_id']) ? $permissionParams['app_id'] : '',
            'name' => !empty($permissionParams['name']) ? $permissionParams['name'] : '',
            'parent_id' => isset($permissionParams['parent_id']) ? $permissionParams['parent_id'] : ''
        ]);
        if (!empty($permission) && $permission->code == 200) {
            return (array)$permission->data;
        }
        return [];
    }

    /**
     * update permission by id and permissionParams
     *
     * @param array $permissionParams
     * @param integer $id
     * @return array
     */

    public function update(array $permissionParams, int $id): array
    {
        $permission = $this->makeRequest('PUT', config('account-service.url.permission.update') . '/' . $id, true, [
            'name' => !empty($permissionParams['name']) ? $permissionParams['name'] : '',
        ]);
        if (!empty($permission) && $permission->code == 200) {
            return (array)$permission->data;
        }
        return [];
    }

    /**
     * destroy permission by id
     *
     * @param integer $id
     * @return array
     */

    public function destroy(int $id): array
    {
        $permission = $this->makeRequest('DELETE', config('account-service.url.permission.delete') . '/' . $id, true);
        if (!empty($permission) && $permission->code == 200) {
            return ['id' => $id];
        }
        return [];
    }
}
