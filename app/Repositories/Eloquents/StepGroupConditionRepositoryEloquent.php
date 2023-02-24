<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\StepGroupCondition;
use App\Repositories\StepGroupConditionRepositoryInterface;
use App\Validators\StepGroupConditionValidator;

/**
 * Class StepGroupConditionRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class StepGroupConditionRepositoryEloquent extends BaseRepository implements StepGroupConditionRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StepGroupCondition::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return StepGroupConditionValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\StepGroupConditionPresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
