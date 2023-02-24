<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Services\DepartmentService;
use Illuminate\Http\JsonResponse;

class DepartmentController extends BaseController
{
    /**
     * DepartmentController constructor.
     *
     * @param DepartmentService $service
     */

    public function __construct(
        protected DepartmentService $service
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/departments",
     *     operationId="getDepartmentList",
     *     tags={"Departments"},
     *     summary="Dữ liệu danh sách phòng ban",
     *     description="Returns Dữ liệu danh sách phòng ban",
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
     *                  {
     *                      "id": "1",
     *                      "name": "phòng A",
     *                      "code": "20G0001"
     *                  },
     *                  {
     *                      "id": "2",
     *                      "name": "phòng B",
     *                      "code": "20G0002"
     *                  }},
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
        $departments = $this->service->all();
        return $this->responseSuccess($departments);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/departments/{id}",
     *    tags={"Departments"},
     *     summary="Get departments by department id",
     *     operationId="getDepartmentsById",
     *     description="Returns a single departments.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
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
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $department = $this->service->show($id);
        return $this->responseSuccess($department);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/department/activate/{id}",
     *    tags={"Departments"},
     *     summary="Set status of department by department_id",
     *     operationId="activateDepartment",
     *     description="Returns activateDepartment",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
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
     *                      "code": 200,
     *                      "message": "activated successfully.",
     *                      "data": null
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *                  )
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function activateDepartment(int $id): JsonResponse
    {
        $activate = $this->service->activateDepartment($id);
        return $this->responseSuccess($activate);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/department/deactivate/{id}",
     *    tags={"Departments"},
     *     summary="Set status of department by department_id",
     *     operationId="deactivateDepartment",
     *     description="Returns deactivateDepartment",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
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
     *                      "code": 200,
     *                      "message": "activated successfully.",
     *                      "data": null
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *                  )
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deactivateDepartment(int $id): JsonResponse
    {
        $deactivate = $this->service->deactivateDepartment($id);
        return $this->responseSuccess($deactivate);
    }
}
