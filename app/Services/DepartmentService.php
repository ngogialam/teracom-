<?php

namespace App\Services;

use App\Traits\GuzzleRequest;

class DepartmentService
{
    use GuzzleRequest;

    public function __construct()
    {
        //
    }

    /**
     * get all departments
     * @return array
     */
    public function all(): array
    {
        $departments = $this->makeRequest('GET', config('account-service.url.department.list'));
        if (!empty($departments) && $departments->code === 200) {
            return (array)$departments->data;
        }
        return [];
    }

    /**
     * show departments by id
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $departments = $this->makeRequest('GET', config('account-service.url.department.list'));
        if (!empty($departments) && $departments->code === 200) {
            foreach ($departments->data as $department) {
                if ($department->id == $id) {
                    return (array)$department;
                }
            }
        }
        return [];
    }

    /**
     * activate departments by department_id
     * @param int $id
     * @return array
     */
    public function activateDepartment(int $id): array
    {
        if (empty($id)) {
            return [];
        }
        $activate = $this->makeRequest('PUT', config('account-service.url.department.activate'), true, [
            'department_id' => $id
        ]);
        if (!empty($activate) && $activate->code === 200) {
            return (array)$activate;
        }
        return [];
    }

    /**
     * activate departments by department_id
     * @param int $id
     * @return array
     */
    public function deactivateDepartment(int $id): array
    {
        if (empty($id)) {
            return [];
        }
        $deactivate = $this->makeRequest('PUT', config('account-service.url.department.deactivate'), true, [
            'department_id' => $id
        ]);
        if (!empty($deactivate) && $deactivate->code === 200) {
            return (array)$deactivate;
        }
        return [];
    }
}
