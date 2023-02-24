<?php

namespace App\Services;

use App\Repositories\StepCheckListRepositoryInterface;

class StepCheckListService
{
    public function __construct(
        protected StepCheckListRepositoryInterface $repository,
    ) {
        //
    }

    /**
     * add step check list
     *
     * @param array $params
     * @return array
     */
    public function store(array $params): array
    {
        if (!isGoodArrayBeforeInsert($params)) {
            return [];
        }
        $stepCheckList = $this->repository->insert($params);
        if ($stepCheckList === true) {
            return $params;
        }
        return [];
    }

    /**
     * update step check list
     *
     * @param array $params
     * @param integer $id
     * @return void
     */
    public function update(array $params, int $id): void
    {
        $this->repository->update($params, $id);
    }
}
