<?php

namespace App\Repositories\Eloquents;

use App\Models\TicketApprovalLog;
use App\Repositories\TicketApprovalLogRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class TicketRequestRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquents;
 */
class TicketApprovalLogRepositoryEloquent extends BaseRepository implements TicketApprovalLogRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TicketApprovalLog::class;
    }
}
