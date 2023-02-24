<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\StepChecklist;
use App\Repositories\StepCheckListRepositoryInterface;
use App\Validators\StepCheckListValidator;

/**
 * Class StepCheckListRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class StepCheckListRepositoryEloquent extends BaseRepository implements StepCheckListRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StepChecklist::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return StepCheckListValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
