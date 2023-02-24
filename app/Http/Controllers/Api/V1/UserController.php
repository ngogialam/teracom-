<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController
{
    //
    /**
     * UserController constructor.
     *
     * @param UserService $service
     */
    public function __construct(
        protected UserService $service
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     operationId="getUserList",
     *     tags={"User"},
     *     summary="Dữ liệu danh sách nhân viên",
     *     description="Returns Dữ liệu danh sách nhân viên",
     *     @OA\RequestBody(
     *        required=false,
     *        @OA\JsonContent(
     *          @OA\Property(
     *              property="limit",
     *              description="users limit",
     *              example="10"
     *          ),
     *          @OA\Property(
     *              property="page",
     *              description="users page",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="department_id",
     *              description="users department_id",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="group_id",
     *              description="users group_id",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="status",
     *              description="users status",
     *              example="1"
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
     *                example={{
     *                  "id": "1",
     *                  "fullname": "Nguyễn Văn A",
     *                  "email": "angyen@gmail.com",
     *                  "department_id": "1",
     *                  "role_id": "1"
     *                }, {
     *                  "id": "2",
     *                  "fullname": "Nguyễn Văn b",
     *                  "email": "bngyen@gmail.com",
     *                  "department_id": "2",
     *                  "role_id": "2"
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

    public function index(Request $request): JsonResponse
    {
        $users = $this->service->all($request->all());
        return $this->responseSuccess($users);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{userId}",
     *    tags={"User"},
     *     summary="Get user by process id",
     *     operationId="getUserById",
     *     description="Returns a single user.",
     *     @OA\Parameter(
     *         name="userId",
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
     *                  "id": 869,
     *                  "code": null,
     *                  "email": "mor.test02@ggg.com.vn",
     *                  "user_name": "mor.test02",
     *                  "full_name": "mor.test02",
     *                  "status": 1,
     *                  "department": {
     *                      "id": 43,
     *                      "name": "Maintenance"
     *                  },
     *                  "division": {
     *                      "id": 67,
     *                      "name": "Maintenance_HCM"
     *                  },
     *                      "roles": {
     *                      "id": 7,
     *                      "name": "HOD",
     *                      "manager_place": null
     *                  },
     *                  "groups": {}
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
    public function show(int $id): JsonResponse
    {
        $user = $this->service->show($id);
        return $this->responseSuccess($user);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users-of-departments",
     *    tags={"User"},
     *     summary="Get user of department",
     *     operationId="usersOfDepartment",
     *     description="Returns user of department",
     *     @OA\RequestBody(
     *        required=false,
     *        @OA\JsonContent(
     *          @OA\Property(
     *              property="department_ids",
     *              description="User department_ids",
     *              example="[21]"
     *          ),
     *          @OA\Property(
     *              property="group_id",
     *              description="User group_id",
     *              example="21"
     *          ),
     *        )
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
     *                      "id": 2,
     *                      "employee_id": 1,
     *                      "user_name": "trung.cuquang",
     *                      "full_name": "Cù Quang Trung",
     *                      "email": "trung.cuquang@ggg.com.vn",
     *                      "is_admin": 0,
     *                      "status": 1,
     *                      "created_at": "2022-07-06T07:53:15.000000Z",
     *                      "updated_at": null,
     *                      "deleted_at": null,
     *                      "department": {
     *                          "id": 21,
     *                          "name": "Excellence Operations & TnD"
     *                      },
     *                      "division": null
     *                  },
     *                  {
     *                      "id": 350,
     *                      "employee_id": 503,
     *                      "user_name": "van.do",
     *                      "full_name": "Đỗ Thị Vân",
     *                      "email": "van.do@ggg.com.vn",
     *                      "is_admin": 0,
     *                      "status": 1,
     *                      "created_at": "2022-07-06T07:53:16.000000Z",
     *                      "updated_at": null,
     *                      "deleted_at": null,
     *                      "department": {
     *                      "id": 21,
     *                      "name": "Excellence Operations & TnD"
     *                      },
     *                      "division": null
     *                  },},
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersByDepartmentIds(Request $request): JsonResponse
    {
        $users = $this->service->getUsersByDepartmentIds($request->all());
        return $this->responseSuccess($users);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/groups-paging",
     *    tags={"User"},
     *     summary="Get paging groups",
     *     operationId="groupsPaging",
     *     description="Returns groups list",
     *     @OA\RequestBody(
     *        required=false,
     *        @OA\JsonContent(
     *          @OA\Property(
     *              property="limit",
     *              description="group limit",
     *              example="10"
     *          ),
     *          @OA\Property(
     *              property="page",
     *              description="group page",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="name",
     *              description="group name",
     *              example="nhom leader"
     *          )
     *        )
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
     *                      "id": 24,
     *                      "code": "26",
     *                      "name": "nho26",
     *                      "status": 0,
     *                      "permissions": {
     *                          {
     *                              "id": 1,
     *                              "name": "Dashboard"
     *                          }
     *                     }
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListGroupsPaging(Request $request): JsonResponse
    {
        $groups = $this->service->getListGroupsPaging($request->all());
        return $this->responseSuccess($groups);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/groups",
     *    tags={"User"},
     *     summary="Get groups list",
     *     operationId="groupsList",
     *     description="Returns groups list",
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
     *                example={
     *                      {
     *                          "id": 25,
     *                          "name": "ad32"
     *                      },
     *                      {
     *                          "id": 26,
     *                          "name": "ad3ll2"
     *                      }
     *                  },
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllGroups(): JsonResponse
    {
        $groups = $this->service->getAllGroups();
        return $this->responseSuccess($groups);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/groups/{id}",
     *    tags={"User"},
     *     summary="Get group detail",
     *     operationId="group detail",
     *     description="Returns groups detail",
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
     *                      "id": 24,
     *                      "code": "26",
     *                      "name": "nho26",
     *                      "status": 0,
     *                      "permissions": {
     *                          {
     *                              "id": 1,
     *                              "name": "Dashboard"
     *                          }
     *                     }
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
    public function showGroup(int $id): JsonResponse
    {
        $group = $this->service->showGroup($id);
        return $this->responseSuccess($group);
    }

    /**
     * @OA\POST(
     *     path="/api/v1/groups",
     *    tags={"User"},
     *     summary="Create group",
     *     operationId="Creategroup",
     *     description="Returns Create group",
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          @OA\Property(
     *              property="status",
     *              description="group status",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="name",
     *              description="group name",
     *              example="nhom leader"
     *          ),
     *          @OA\Property(
     *              property="code",
     *              description="group code",
     *              example="123"
     *          ),
     *          @OA\Property(
     *              property="permission_id",
     *              description="group permission_id",
     *              example="1",
     *              enum={1,2,3,4,5}
     *          ),
     *          @OA\Property(
     *              property="description",
     *              description="group description",
     *              example="abc"
     *          )
     *        )
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeGroups(Request $request): JsonResponse
    {
        $group = $this->service->storeGroup($request->all());
        return $this->responseSuccess($group);
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/groups/{id}",
     *     tags={"User"},
     *     summary="Update group",
     *     operationId="Updategroup",
     *     description="Returns Update group",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="id",
     *          description="id of groups",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          @OA\Property(
     *              property="status",
     *              description="group status",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="name",
     *              description="group name",
     *              example="nhom leader"
     *          ),
     *          @OA\Property(
     *              property="code",
     *              description="group code",
     *              example="123"
     *          ),
     *          @OA\Property(
     *              property="permission_id",
     *              description="group permission_id",
     *              example="1",
     *              enum={1,2,3,4,5}
     *          ),
     *          @OA\Property(
     *              property="description",
     *              description="group description",
     *              example="abc"
     *          )
     *        )
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
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateGroups(Request $request, int $id): JsonResponse
    {
        $group = $this->service->updateGroup($request->all(), $id);
        return $this->responseSuccess($group);
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/users/{id}",
     *     tags={"User"},
     *     summary="Update user",
     *     operationId="Updateuser",
     *     description="Returns Update user",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="id",
     *          description="id of user",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *          @OA\Property(
     *              property="status",
     *              description="group status",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="direct_management_id",
     *              description="group direct_management_id",
     *              example="[3,4]"
     *          ),
     *          @OA\Property(
     *              property="indirect_management_id",
     *              description="group indirect_management_id",
     *              example="[5,6]"
     *          ),
     *          @OA\Property(
     *              property="percentage",
     *              description="group percentage",
     *              example="[20,40]"
     *          ),
     *          @OA\Property(
     *              property="group_id",
     *              description="group group_id",
     *              example="[2,3]"
     *          ),
     *          @OA\Property(
     *              property="role_id",
     *              description="group role_id",
     *              example="2"
     *          ),
     *          @OA\Property(
     *              property="manager_place",
     *              description="group manager_place",
     *              example="[1,2]"
     *          )
     *        )
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
     *                  example={{
     *                  "id": 869,
     *                  "code": null,
     *                  "email": "mor.test02@ggg.com.vn",
     *                  "user_name": "mor.test02",
     *                  "full_name": "mor.test02",
     *                  "status": 1,
     *                  "department": {
     *                      "id": 43,
     *                      "name": "Maintenance"
     *                  },
     *                  "division": {
     *                      "id": 67,
     *                      "name": "Maintenance_HCM"
     *                  },
     *                      "roles": {
     *                      "id": 7,
     *                      "name": "HOD",
     *                      "manager_place": null
     *                  },
     *                  "groups": {}
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
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request, int $id): JsonResponse
    {
        $user = $this->service->updateUser($request->all(), $id);
        return $this->responseSuccess($user);
    }

    /**
     * @OA\DELETE(
     *     path="/api/v1/users/{id}",
     *     tags={"User"},
     *     summary="Delete group",
     *     operationId="Deletegroup",
     *     description="Returns Delete group",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="id",
     *          description="id of group",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
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
     *                  example={
     *                      "id":11
     *                  },
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
    public function deleteGroup(int $id): JsonResponse
    {
        $groupId = $this->service->deleteGroup($id);
        return $this->responseSuccess($groupId);
    }
}
