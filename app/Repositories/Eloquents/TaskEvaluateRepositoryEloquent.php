<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\TaskEvaluate;
use App\Repositories\TaskEvaluateRepositoryInterface;
use App\Validators\TaskEvaluateValidator;

/**
 * Class TaskEvaluateRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class TaskEvaluateRepositoryEloquent extends BaseRepository implements TaskEvaluateRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TaskEvaluate::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return TaskEvaluateValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\TaskEvaluatePresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
