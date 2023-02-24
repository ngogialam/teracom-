<?php

namespace App\Services;

use App\Repositories\StepGroupConditionRepositoryInterface;

class StepGroupConditionService
{
    public function __construct(
        protected StepGroupConditionRepositoryInterface $repository
    ) {
    }

    /**
     * get all steps group condition
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        if (empty($params['group_first_step'])) {
            return [];
        }
        $stepGroupConditions = $this->repository->findWhere([
            'group_first_step' => $params['group_first_step']
        ]);
        return $stepGroupConditions;
    }

    /**
     * create new step group condition
     *
     * @param array $params
     * @return array
     */
    public function create(array $params): array
    {
        return $this->repository->create($params);
    }

    /**
     * show step group condition by id
     *
     * @param integer $id
     * @return array
     */
    public function show(int $id): array
    {
        return $this->repository->find($id);
    }

    /**
     * update step group condition
     *
     * @param array $params
     * @param integer $id
     * @return array
     */
    public function update(array $params, int $id): array
    {
        return $this->repository->update($params, $id);
    }

    /**
     * delete step group condition
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
