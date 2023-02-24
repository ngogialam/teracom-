<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\TaskTimesheet;
use App\Repositories\TaskTimesheetRepositoryInterface;
use App\Validators\TaskTimesheetValidator;

/**
 * Class TaskTimesheetRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class TaskTimesheetRepositoryEloquent extends BaseRepository implements TaskTimesheetRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TaskTimesheet::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TaskTimesheetValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
