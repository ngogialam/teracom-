<?php

namespace App\Services;

use App\Repositories\TicketHistoryRepositoryInterface;
use Illuminate\Support\Str;
use App\Http\Controllers\BaseController;

class TicketHistoryService
{
    public function __construct(
        protected TicketHistoryRepositoryInterface $repository,
    ) {
        //
    }

    /**
     * get all ticket history
     *
     * @param array $params
     * @return array
     */
    public function all(array $params): array
    {
        $limit = !empty($params['limit']) ? $params['limit'] : BaseController::DEFAULT_LIMIT;
        $page = !empty($params['page']) ? $params['page'] : BaseController::DEFAULT_PAGE;
        $response = [
            "list" => [],
            "limit" => $limit,
            "page" => $page
        ];
        if (empty($params['ticket_req_id'])) {
            return $response;
        }
        $ticketHistories =  $this->repository->orderBy('id', 'desc')
            ->where('ticket_req_id', $params['ticket_req_id'])
            ->skip(($page - 1) * $limit)
            ->take($limit)
            ->get();
        foreach ($ticketHistories as $key => $ticketHistory) {
            $ticketHistories[$key]['name'] = Str::random(7);
        }
        $response['list'] = $ticketHistories;
        return $response;
    }
}
