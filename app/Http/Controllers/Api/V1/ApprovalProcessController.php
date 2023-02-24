<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Controllers\BaseController;
use App\Services\ApprovalProcessService;
use Illuminate\Http\JsonResponse;

/**
 * Class ApprovalProcessController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class ApprovalProcessController extends BaseController
{
    /**
     * ProcessStepsController constructor.
     *
     * @param ApprovalProcessService $service
     */
    public function __construct(
        protected ApprovalProcessService $service
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/approval-process",
     *     operationId="getApprovalProcessList",
     *     tags={"ApprovalProcess"},
     *     summary="Get list of my flows",
     *     description="Returns list of my approval process",
     *      @OA\Parameter(
     *          required=true,
     *          in="query",
     *          name="process_id",
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
     *                example={{
     *                  "id": 1,
     *                  "process_id":1,
     *                  "approval_status":1,
     *                  "comment":"hahah hog cos gi",
     *                  "created_at": 22,
     *                  "updated_at": 22,
     *                  "created_by": 1,
     *                  "updated_by": 1,
     *                  "name": "gggghh",
     *
     *                }, {
     *                  "id": 2,
     *                  "process_id":2,
     *                  "approval_status":0,
     *                  "comment":"hahah hog cos gi dau",
     *                  "created_at": 32,
     *                  "updated_at": 32,
     *                  "created_by": 3,
     *                  "updated_by": 2,
     *                  "name": "ghh",
     *                }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/ProcessApprovePresenter"
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $approvalProcessLogs = $this->service->all($request->all());

        return $this->responseSuccess($approvalProcessLogs['data']);
    }
}
