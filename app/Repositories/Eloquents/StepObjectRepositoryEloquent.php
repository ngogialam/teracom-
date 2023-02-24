<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\StepObject;
use App\Repositories\StepObjectRepositoryInterface;
use App\Validators\StepObjectValidator;

/**
 * Class StepObjectRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class StepObjectRepositoryEloquent extends BaseRepository implements StepObjectRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StepObject::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return StepObjectValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\StepObjectPresenter";
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
