<?php

namespace App\Services;

use App\Repositories\TaskObjectRepositoryInterface;

class TaskObjectService
{
    public function __construct(
        protected TaskObjectRepositoryInterface $repository,
    ) {
        //
    }

    /**
     * Get all task object
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        if (empty($params['task_id'])) {
            return ["data" => []];
        }
        return $this->repository->orderBy('id', 'desc')->findWhere(['task_id' => $params['task_id']]);
    }

    /**
     * create new task object
     *
     * @param array $params
     * @return array
     */
    public function create(array $params): array
    {
        $this->repository->insert(abandonNulValue($params));
        return $params;
    }

    /**
     * update task object
     *
     * @param array $params
     * @param int $id
     * @return void
     */
    public function update(array $params, int $id): void
    {
        $this->repository->update($params, $id);
    }

    /**
     * delete task object
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
