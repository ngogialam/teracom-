<?php

namespace App\Repositories\Eloquents;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\TicketRequest;
use App\Repositories\TicketRequestRepositoryInterface;
use App\Validators\TicketRequestValidator;

/**
 * Class TicketRequestRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class TicketRequestRepositoryEloquent extends BaseRepository implements TicketRequestRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketRequest::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return TicketRequestValidator::class;
    }

    public function presenter()
    {
        return "App\\Presenters\\TicketRequestPresenter";
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
