<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Validators\ProcessChangeLogValidator;
use App\Services\ProcessChangeLogService;
use Illuminate\Http\JsonResponse;

/**
 * Class ProcessChangeLogsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class ProcessChangeLogsController extends BaseController
{
    /**
     * ProcessChangeLogsController constructor.
     *
     * @param ProcessChangeLogValidator $validator
     * @param ProcessChangeLogService $service
     */
    public function __construct(
        protected ProcessChangeLogValidator $validator,
        protected ProcessChangeLogService $service
    ) {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/v1/process-change-log",
     *     operationId="getProcessChangeLogList",
     *     tags={"Process Change Log"},
     *     summary="Get list of process change log",
     *     description="Returns list of process change log",
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
     *                example={
     *                   "list": {
     *                             {
     *                                "id": 3,
     *                                "process_id": "3",
     *                                "description": "fhgngndgb",
     *                                "created_by": 1,
     *                                "created_at": 24445,
     *                                "updated_at": 45445,
     *                                "updated_by": 12,
     *                                "change_type": 1,
     *                                "version": 1,
     *                                "old_version": 1,
     *                                "name": "GwiFSNO"
     *                             },
     *                             {
     *                                "id": 2,
     *                                "process_id": "3",
     *                                "description": "fhgddghngndgb",
     *                                "created_by": 1,
     *                                "created_at": 244445,
     *                                "updated_at": 453445,
     *                                "updated_by": 12,
     *                                "change_type": 1,
     *                                "version": 1,
     *                                "old_version": 1,
     *                                "name": "GwiFpNO"
     *                              },
     *                            },
     *                       "page": {
     *                           "limit": 10,
     *                           "page": 1
     *                               },
     *                      },
     *                  @OA\Items(
     *                      type="object",
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
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        $processChangeLogs = $this->service->all($request->all());
        return $this->responseSuccess($processChangeLogs);
    }
}
