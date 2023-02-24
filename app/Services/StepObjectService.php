<?php

namespace App\Services;

use App\Repositories\StepObjectRepositoryInterface;
use App\Repositories\ProcessChangeLogRepositoryInterface;
use App\Models\StepObject;
use App\Models\ProcessChangeLog;
use Carbon\Carbon;

class StepObjectService
{
    public function __construct(
        protected StepObjectRepositoryInterface $repository,
        protected ProcessChangeLogRepositoryInterface $processChangeLogRepository,
    ) {
        //
    }

    /**
     * Get all step object
     *
     * @return array
     */
    public function all(): array
    {
        return $this->repository->all();
    }

    /**
     * Create new step object
     *
     * @param array $params
     * @return void
     */
    public function store(array $params): void
    {
        $this->repository->insert($params);
    }

    /**
     * Get step object by id
     *
     * @param integer $id
     * @return array
     */
    public function show(int $id): array
    {
        return $this->repository->find($id);
    }

    /**
     * Delete step object by id
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    /**
     * update step object
     *
     * @param array $params
     * @param integer $id
     * @return array
     */
    public function update(array $params, int $id): array
    {
        $stepObject = $this->repository->find($id);
        if (
            !empty($params['active'])
            && $stepObject['data']['active'] != $params['active']
            && $params['active'] == StepObject::ACTIVE
        ) {
            $this->makeChangeLog(ProcessChangeLog::CHANGE_TYPE_ACTIVE, $stepObject['data']['process_id']);
            $this->makeChangeLog(ProcessChangeLog::CHANGE_TYPE_NEXT, $stepObject['data']['process_id']);
        }
        return $this->repository->update($params, $id);
    }

    /**
     * Create change log when have change from process
     *
     * @param integer $changeLogStatus
     * @param integer $processId
     * @return void
     */
    private function makeChangeLog(int $changeLogStatus, int $processId): void
    {
        $faker = \Faker\Factory::create();
        $this->processChangeLogRepository->create([
            'description' => $faker->sentence,
            'created_by' => $faker->numerify("##########"),
            'created_at' => Carbon::now()->timestamp,
            'updated_at' => Carbon::now()->timestamp,
            'updated_by' => $faker->numerify("##########"),
            'change_type' => $changeLogStatus,
            'version' => 1,
            'old_version' => 1,
            'process_id' => $processId,
        ]);
    }
}
