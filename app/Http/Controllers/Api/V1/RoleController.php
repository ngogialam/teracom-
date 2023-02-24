<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;

class RoleController extends BaseController
{
    /**
     * RoleController constructor.
     *
     * @param RoleService $service
     */
    public function __construct(
        protected RoleService $service
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/roles",
     *     operationId="getRoleList",
     *     tags={"Role"},
     *     summary="Roles list",
     *     description="Returns roles list",
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
     *                  "name": "Account (old)",
     *                  "status": 1,
     *                  "region_id": null,
     *                  "modifier_id": null,
     *                  "created_at": "2022-07-06 14:52:27",
     *                  "updated_at": null,
     *                  "deleted_at": null
     *                }},
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
    public function index(): JsonResponse
    {
        $roles = $this->service->all();
        return $this->responseSuccess($roles);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/roles-by-department",
     *     operationId="getrolesOfDepartment",
     *     tags={"Role"},
     *     summary="Roles Of Department",
     *     description="Returns Roles Of Department",
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          @OA\Property(
     *              property="department_ids",
     *              description="User department_ids",
     *              type="array",
     *                example={{
     *                  "id": 41,
     *                },
     *                {
     *                  "id": 42,
     *                },
     *                },
     *                @OA\Items(
     *                    type="object",
     *                )
     *          ),
     *        )
     *     ),
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
     *                  "name": "Account (old)",
     *                  "status": 1,
     *                  "region_id": null,
     *                  "modifier_id": null,
     *                  "created_at": "2022-07-06 14:52:27",
     *                  "updated_at": null,
     *                  "deleted_at": null
     *                }},
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRolesByDepartmentIds(Request $request): JsonResponse
    {
        $roles = $this->service->getRolesByDepartmentIds($request->all());
        return $this->responseSuccess($roles);
    }
}
