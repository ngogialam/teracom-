<?php

namespace App\Services;

use App\Traits\GuzzleRequest;

class RoleService
{
    use GuzzleRequest;

    public function __construct()
    {
        //
    }

    /**
     * get all roles
     *
     * @return array
     */
    public function all(): array
    {
        $roles = $this->makeRequest('GET', config('account-service.url.role'), true);
        if (!empty($roles) && $roles->code === 200) {
            return (array)$roles->data;
        }
        return [];
    }

    /**
     * get role by department ids
     *
     * @param array $departmentParams
     * @return array
     */
    public function getRolesByDepartmentIds(array $departmentParams): array
    {
        if (empty($departmentParams['department_ids'])) {
            return [];
        }
        $roles = [];
        $users = $this->makeRequest('GET', config('account-service.url.user.full'), true, [
            'department_ids' => $departmentParams['department_ids']
        ]);
        if (!empty($users) && $users->code == 200) {
            foreach ($users->data as $user) {
                foreach ($user->roles as $role) {
                    if (empty($roles[$role->code])) {
                        $roles[$role->code] = $role;
                    }
                }
            }
        }
        return $roles;
    }
}
