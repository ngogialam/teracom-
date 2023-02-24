<?php

namespace App\Services;

use App\Repositories\TaskEvaluateRepositoryInterface;

class TaskEvaluateService
{
    public function __construct(
        protected TaskEvaluateRepositoryInterface $repository,
    ) {
        //
    }

    /**
     * get all tasks evaluate
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
     * create new task evaluation
     *
     * @param array $params
     * @return array
     */
    public function create(array $params): array
    {
        return $this->repository->insert(abandonNulValue($params));
    }

    /**
     * show task evaluate by id
     *
     * @param integer $id
     * @return array
     */
    public function show(int $id): array
    {
        return $this->repository->find($id);
    }

    /**
     * update task evaluate
     *
     * @param array $params
     * @param integer $id
     * @return void
     */
    public function update(array $params, int $id): void
    {
        $this->repository->update($params, $id);
    }

    /**
     * delete task evaluate by id
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
