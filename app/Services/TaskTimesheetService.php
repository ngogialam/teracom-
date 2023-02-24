<?php

namespace App\Services;

use App\Repositories\TaskTimesheetRepositoryInterface;

class TaskTimesheetService
{
    public function __construct(
        protected TaskTimesheetRepositoryInterface $repository,
    ) {
        //
    }

    /**
     * get all tasks timesheet
     *
     * @return array
     */
    public function all(): array
    {
        return $this->repository->orderBy('id', 'desc')->all();
    }

    /**
     * create new task timesheet
     *
     * @param array $input
     * @return array
     */
    public function create(array $input): array
    {
        return $this->repository->insert(abandonNulValue($input));
    }

    /**
     * get task timesheet by id
     *
     * @param integer $id
     * @return array
     */
    public function show(int $id): array
    {
        return $this->repository->find($id);
    }

    /**
     * Update task timesheet
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
     * delete timesheet by id
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
