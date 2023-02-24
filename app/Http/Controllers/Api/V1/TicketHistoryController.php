<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Validators\TicketHistoryValidator;
use App\Http\Controllers\BaseController;
use App\Services\TicketHistoryService;
use Illuminate\Http\JsonResponse;

/**
 * Class TicketHistoryController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class TicketHistoryController extends BaseController
{
    /**
     * TicketHistoriesController constructor.
     *@param TicketHistoryService $service
     * @param TicketHistoryValidator $validator
     */
    public function __construct(
        protected TicketHistoryService $service,
        protected TicketHistoryValidator $validator,
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/ticket-history",
     *     operationId="getTicketHistoryList",
     *     tags={"TicketHistory"},
     *     summary="list history ticket",
     *     description="Returns list of my ticket history",
     *      @OA\Parameter(
     *          required=true,
     *          in="query",
     *          name="ticket_req_id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  type="integer",
     *                  default="200",
     *                  property="code"
     *              ),
     *              @OA\Property(
     *                  type="string",
     *                  default="SUCCESS",
     *                  property="message"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                example={
     *                  "list": {
     *                            {
     *                                 "id": 1,
     *                                 "ticket_req_id": 2,
     *                                 "approval_status": 1,
     *                                 "comment": "gfgfhfhfhbfbhf",
     *                                 "created_by": 222,
     *                                 "created_at": "1970-01-01T00:03:42.000000Z",
     *                                 "updated_at": "1970-01-01T00:03:32.000000Z",
     *                                 "updated_by": 2222,
     *                                 "deleted_at": 222,
     *                                 "name": "k65xomM"
     *                             },
     *                             {
     *                                 "id": 2,
     *                                 "ticket_req_id": 2,
     *                                 "approval_status": 1,
     *                                 "comment": "gfgfhfgfhfhbfbhf",
     *                                 "created_by": 2,
     *                                 "created_at": "1970-01-01T00:03:42.000000Z",
     *                                 "updated_at": "1970-01-01T00:03:32.000000Z",
     *                                 "updated_by": 2222,
     *                                 "deleted_at": 222,
     *                                 "name": "khghhgM"
     *                             },
     *                           },
     *                    "page": {
     *                       "limit": 10,
     *                       "page": 1
     *                            },
     *                         },
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/TicketHistoryPresenter"
     *                  )
     *              ),
     *          ),
     *       ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated",
     *     ),
     *    @OA\Response(
     *        response=403,
     *        description="Forbidden",
     *    ),
     * )
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $ticketHistory = $this->service->all($request->all());
        return $this->responseSuccess($ticketHistory);
    }
}
