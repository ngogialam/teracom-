<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProcessCommentsRepositoryInterface;
use App\Models\ProcessComments;
use App\Validators\ProcessCommentsValidator;

/**
 * Class ProcessCommentsRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class ProcessCommentsRepositoryEloquent extends BaseRepository implements ProcessCommentsRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProcessComments::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return ProcessCommentsValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\ProcessCommentsPresenter";
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
