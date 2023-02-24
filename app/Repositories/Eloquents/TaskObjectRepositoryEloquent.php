<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\TaskObject;
use App\Repositories\TaskObjectRepositoryInterface;
use App\Validators\TaskObjectValidator;

/**
 * Class TaskRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class TaskObjectRepositoryEloquent extends BaseRepository implements TaskObjectRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TaskObject::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return TaskObjectValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\TaskObjectPresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
