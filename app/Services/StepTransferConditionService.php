<?php

namespace App\Services;

use App\Repositories\StepTransferConditionRepositoryInterface;
use Carbon\Carbon;

class StepTransferConditionService
{
    public function __construct(
        protected StepTransferConditionRepositoryInterface $repository
    ) {
    }

    /**
     * get all steps transfer condition
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        if (empty($params['step_id'])) {
            return [];
        }
        $stepTransferConditions = $this->repository->findWhere([
            'step_id' => $params['step_id']
        ]);
        return $stepTransferConditions;
    }

    /**
     * create new step transfer condition
     *
     * @param array $params
     * @return array
     */
    public function create(array $params): array
    {
        return $this->repository->create($params);
    }

    /**
     * get step transfer condition by id
     *
     * @param integer $id
     * @return array
     */
    public function show(int $id): array
    {
        return $this->repository->find($id);
    }

    /**
     * update step transfer condition
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
     * delete step transfer condition by id
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->update(['deleted_at' => Carbon::now()->timestamp], $id);
    }
}
