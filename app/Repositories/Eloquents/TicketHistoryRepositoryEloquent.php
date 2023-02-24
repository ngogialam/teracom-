<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\TicketHistory;
use App\Repositories\TicketHistoryRepositoryInterface;
use App\Services\TicketHistoryService;
use App\Validators\TicketHistoryValidator;

/**
 * Class TicketHistoryRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class TicketHistoryRepositoryEloquent extends BaseRepository implements TicketHistoryRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketHistory::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TicketHistoryValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\TicketHistoryPresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
