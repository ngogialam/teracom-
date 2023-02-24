<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use App\Validators\TaskValidator;

/**
 * Class TaskRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class TaskRepositoryEloquent extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Task::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return TaskValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\TaskPresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
