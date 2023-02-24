<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\ApprovalProcessLog;
use App\Repositories\ApprovalProcessRepositoryInterface;
use App\Validators\ProcessApproveValidator;

/**
 * Class ApprovalProcessRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class ApprovalProcessRepositoryEloquent extends BaseRepository implements ApprovalProcessRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ApprovalProcessLog::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return ProcessApproveValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function presenter()
    {
        return "App\\Presenters\\ProcessApprovePresenter";
    }
}
