<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\ProcessStep;
use App\Repositories\ProcessStepRepositoryInterface;
use App\Validators\ProcessStepValidator;

/**
 * Class ProcessRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class ProcessStepRepositoryEloquent extends BaseRepository implements ProcessStepRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProcessStep::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProcessStepValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\ProcessStepPresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
