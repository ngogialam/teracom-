<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\PermissionService;
use Illuminate\Http\JsonResponse;

class PermissionController extends BaseController
{

    /**
     * RoleController constructor.
     *
     * @param PermissionService $service
     */
    public function __construct(
        protected PermissionService $service
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/permission",
     *     operationId="getPermissionList",
     *     tags={"Permission"},
     *     summary="permission list",
     *     description="Returns permission list",
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
     *                  "app_name": "G-PMS",
     *                  "permissions": {
     *                      {
     *                          "id": 1,
     *                          "name": "Dashboard"
     *                      },
     *                      {
     *                          "id": 2,
     *                          "name": "Quản lý timesheet"
     *                      },
     *                      {
     *                          "id": 3,
     *                          "name": "Báo cáo"
     *                      },
     *                      {
     *                          "id": 4,
     *                          "name": "Quản trị hệ thống",
     *                          "sub_permissions": {
     *                              {
     *                                  "id": 5,
     *                                  "name": "Quản trị nhóm người dùng"
     *                              },
     *                              {
     *                                  "id": 6,
     *                                  "name": "Quản trị người dùng"
     *                              }
     *                          }
     *                      }
     *                  }
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
        $permissions = $this->service->all();
        return $this->responseSuccess($permissions);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/permission",
     *     operationId="createPermission",
     *     tags={"Permission"},
     *     summary="create permission",
     *     description="Returns permission",
     *     @OA\RequestBody(
     *        required=false,
     *        @OA\JsonContent(
     *          @OA\Property(
     *              property="app_id",
     *              description="group app_id",
     *              example="3"
     *          ),
     *          @OA\Property(
     *              property="parent_id",
     *              description="group parent_id",
     *              example="0"
     *          ),
     *          @OA\Property(
     *              property="name",
     *              description="group name",
     *              example="Permission"
     *          )
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
     *                example={
     *                  "code": 200,
     *                  "message": "success",
     *                  "data": null
     *                  },
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $permission = $this->service->create($request->all());
        return $this->responseSuccess($permission);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/permission/{id}",
     *     operationId="updatePermission",
     *     tags={"Permission"},
     *     summary="update permission",
     *     description="Returns permission",
     *     @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="id",
     *          description="id of permission",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *        required=false,
     *        @OA\JsonContent(
     *          @OA\Property(
     *              property="name",
     *              description="group name",
     *              example="Permission"
     *          )
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
     *                example={
     *                  "code": 200,
     *                  "message": "success",
     *                  "data": null
     *                  },
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $permission = $this->service->update($request->all(), $id);
        return $this->responseSuccess($permission);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/permission/{id}",
     *     operationId="deletePermission",
     *     tags={"Permission"},
     *     summary="delete permission",
     *     description="Returns id of permission",
     *     @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="id",
     *          description="id of permission",
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
     *                  "id":1
     *                  },
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
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $permissionId = $this->service->destroy($id);
        return $this->responseSuccess($permissionId);
    }
}
