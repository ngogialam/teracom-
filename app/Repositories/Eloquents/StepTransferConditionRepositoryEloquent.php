<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\StepTransferCondition;
use App\Repositories\StepTransferConditionRepositoryInterface;
use App\Validators\StepTransferConditionValidator;

/**
 * Class StepTransferConditionRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class StepTransferConditionRepositoryEloquent extends BaseRepository implements StepTransferConditionRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StepTransferCondition::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return StepTransferConditionValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\StepTransferConditionPresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
