<?php

namespace App\Services;

use App\Traits\GuzzleRequest;

class UserService
{
    use GuzzleRequest;

    public function __construct()
    {
        //
    }

    /**
     * get all user
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        $users = $this->makeRequest('GET', config('account-service.url.user.paging'), true, [
            'page' => !empty($params['page']) ? $params['page'] : '',
            'limit' => !empty($params['limit']) ? $params['limit'] : '',
            'department_id' => !empty($params['department_id']) ? $params['department_id'] : '',
            'group_id' => !empty($params['group_id']) ? $params['group_id'] : '',
        ]);
        if (!empty($users) && $users->code === 200) {
            return (array)$users->data;
        }
        return [];
    }

    /**
     * show user by id
     *
     * @param integer $id
     * @return array
     */
    public function show(int $id): array
    {
        $users = $this->makeRequest('GET', config('account-service.url.user.info') . "/$id", true);
        if (!empty($users) && $users->code === 200) {
            return (array)$users->data;
        }
        return [];
    }

    /**
     * get list user of department by department id
     *
     * @param array $params
     * @return array
     */
    public function getUsersByDepartmentIds(array $params): array
    {
        $users = $this->makeRequest('GET', config('account-service.url.user.list'), true, [
            'department_ids' => !empty($params['department_ids']) ? $params['department_ids'] : '',
            'group_id' => !empty($params['group_id']) ? $params['group_id'] : ''
        ]);
        if (!empty($users) && $users->code == 200) {
            return (array)$users->data;
        }
        return [];
    }

    /**
     * get paging groups  by params
     *
     * @param array $params
     * @return array
     */
    public function getListGroupsPaging(array $params): array
    {
        $groups = $this->makeRequest('GET', config('account-service.url.group.paging'), true, [
            'page' => !empty($params['page']) ? $params['page'] : '',
            'limit' => !empty($params['limit']) ? $params['limit'] : '',
            'name' => !empty($params['name']) ? $params['name'] : '',
        ]);
        if (!empty($groups) && $groups->code == 200) {
            return (array)$groups->data;
        }
        return [];
    }

    /**
     * get all groups
     *
     * @return array
     */
    public function getAllGroups(): array
    {
        $groups = $this->makeRequest('GET', config('account-service.url.group.list'), true);
        if (!empty($groups) && $groups->code == 200) {
            return (array)$groups->data;
        }
        return [];
    }

    /**
     * showGroup groups by id
     *
     * @param int $id
     * @return array
     */
    public function showGroup(int $id): array
    {
        $groups = $this->getListGroupsPaging([]);
        if (!empty($groups)) {
            $groups = $this->getListGroupsPaging(['limit' => $groups['count'], 'page' => 1]);
            if (!empty($groups)) {
                foreach ($groups['groups'] as $value) {
                    if ($value->id == $id) {
                        return (array)$value;
                    }
                }
            }
        }
        return [];
    }
    /**
     * storeGroups groups by params
     *
     * @param array $params
     * @return array
     */
    public function storeGroup(array $params): array
    {
        $group = $this->makeRequest('POST', config('account-service.url.group.store'), true, $params);
        if (!empty($group) && $group->code == 200) {
            return (array)$group->data;
        }
        if (!empty($group) && $group->code == 400) {
            return (array)$group->message;
        }
        return [];
    }

    /**
     * updateGroups groups by params and id
     *
     * @param array $params
     * @param integer $id
     * @return array
     */
    public function updateGroup(array $params, int $id): array
    {
        $group = $this->makeRequest('PUT', config('account-service.url.group.update') . '/' . $id, true, $params);
        if (!empty($group) && $group->code == 200) {
            return $this->showGroup($id);
        }
        if (!empty($group) && $group->code == 400) {
            return (array)$group->message;
        }
        return [];
    }

    /**
     * updateUser by usersParams and id
     *
     * @param array $usersParams
     * @param integer $id
     * @return array
     */
    public function updateUser(array $usersParams, int $id): array
    {
        $user = $this->makeRequest('PUT', config('account-service.url.user.update') . '/' . $id, true, $usersParams);
        if (!empty($user) && $user->code == 200) {
            return $this->show($id);
        }
        return [];
    }

    /**
     * deleteGroup groups by id
     *
     * @param integer $id
     * @return array
     */
    public function deleteGroup(int $id): array
    {
        $group = $this->makeRequest('DELETE', config('account-service.url.group.delete') . '/' . $id, true);
        if (!empty($group) && $group->code == 200) {
            return ["id" => $id];
        }
        return [];
    }
}
