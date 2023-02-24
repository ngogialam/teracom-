<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\ProcessChangeLog;
use App\Repositories\ProcessChangeLogRepositoryInterface;
use App\Validators\ProcessChangeLogValidator;

/**
 * Class FlowsHistoryRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class ProcessChangeLogEloquent extends BaseRepository implements ProcessChangeLogRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProcessChangeLog::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return ProcessChangeLogValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\ProcessChangeLogPresenter";
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
