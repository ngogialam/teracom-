<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests\TaskObjectCreateRequest;
use App\Http\Requests\TaskObjectUpdateRequest;
use App\Validators\TaskObjectValidator;
use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use App\Services\TaskObjectService;

/**
 * Class TaskObjectsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class TaskObjectController extends BaseController
{
    /**
     * TasksController constructor.
     *
     * @param TaskObjectValidator $validator
     * @param TaskObjectService $service
     */
    public function __construct(
        protected TaskObjectValidator $validator,
        protected TaskObjectService $service
    ) {
    }

     /**
     * @OA\Get(
     *      path="/api/v1/task-object",
     *      operationId="getTaskObjectRequest",
     *      tags={"Task object"},
     *      summary="get list task object",
     *      description="Returns list task object data",
     *       @OA\Parameter(
     *          required=true,
     *          in="query",
     *          name="task_id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
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
     *                  example={{
     *                             "id": 4,
     *                             "task_id": 2,
     *                             "object_action_type": 2,
     *                             "object_type": 2,
     *                             "object_id": 2,
     *                             "object_name": "sffsfđfs",
     *                             "object_position": "2",
     *                             "created_by": 2,
     *                             "created_at": 2313234,
     *                             "updated_at": 1331244,
     *                             "updated_by": 2,
     *                             "deleted_at": 2,
     *                             "ticket_req_id": 2
     *                            },
     *                            {
     *                             "id": 1,
     *                             "task_id": 2,
     *                             "object_action_type": 1,
     *                             "object_type": 1,
     *                             "object_id": 1,
     *                             "object_name": "sffsfs",
     *                             "object_position": "1",
     *                             "created_by": 1,
     *                             "created_at": 21234,
     *                             "updated_at": 131244,
     *                             "updated_by": 1,
     *                             "deleted_at": 1,
     *                             "ticket_req_id": 3
     *                           }},
     *                  @OA\Items(
     *                      type="object",
     *                  )
     *              ),
     *          ),
     *       ),
     *      @OA\Response(
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
     *      )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $taskObject = $this->service->all($request->all());
        return $this->responseSuccess($taskObject['data']);
    }

     /**
     * @OA\Post(
     *      path="/api/v1/task-object",
     *      operationId="storeTaskObjectRequest",
     *      tags={"Task object"},
     *      summary="Store new task object",
     *      description="Returns task object data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaskObjectCreateRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
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
     *                  example={{
     *                             "id": 4,
     *                             "task_id": 2,
     *                             "object_action_type": 2,
     *                             "object_type": 2,
     *                             "object_id": 2,
     *                             "object_name": "sffsfđfs",
     *                             "object_position": "2",
     *                             "created_by": 2,
     *                             "created_at": 2313234,
     *                             "updated_at": 1331244,
     *                             "updated_by": 2,
     *                             "deleted_at": 2,
     *                             "ticket_req_id": 2
     *                            },
     *                            {
     *                             "id": 1,
     *                             "task_id": 2,
     *                             "object_action_type": 1,
     *                             "object_type": 1,
     *                             "object_id": 1,
     *                             "object_name": "sffsfs",
     *                             "object_position": "1",
     *                             "created_by": 1,
     *                             "created_at": 21234,
     *                             "updated_at": 131244,
     *                             "updated_by": 1,
     *                             "deleted_at": 1,
     *                             "ticket_req_id": 3
     *                           }},
     *                  @OA\Items(
     *                      type="object",
     *
     *                  )
     *              ),
     *          ),
     *       ),
     *      @OA\Response(
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
     *      )
     * )
     *
     * @param  TaskObjectCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TaskObjectCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(TaskObjectValidator::RULE_CREATE);

        $this->service->create($request->all());

        return $this->responseSuccess($request->all());
    }

    /**
     * @OA\Put(
     *      path="/api/v1/task-object/{taskObjectId}",
     *      operationId="updateTaskObjectRequest",
     *      tags={"Task object"},
     *      summary="Update the task object",
     *      description="Returns task object data",
     *      @OA\Parameter(
     *         name="taskObjectId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaskObjectUpdateRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
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
     *                  example={{
     *                             "id": 4,
     *                             "task_id": 2,
     *                             "object_action_type": 2,
     *                             "object_type": 2,
     *                             "object_id": 2,
     *                             "object_name": "sffsfđfs",
     *                             "object_position": "2",
     *                             "created_by": 2,
     *                             "created_at": 2313234,
     *                             "updated_at": 1331244,
     *                             "updated_by": 2,
     *                             "deleted_at": 2,
     *                             "ticket_req_id": 2
     *                            }},
     *                  @OA\Items(
     *                      type="object",
     *
     *                  )
     *              ),
     *          ),
     *       ),
     *      @OA\Response(
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
     *      )
     * )
     *
     * @param  TaskObjectUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TaskObjectUpdateRequest $request, int $id): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(TaskObjectValidator::RULE_UPDATE);

        $this->service->update($request->all(), $id);

        return $this->responseSuccess($request->all());
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/task-object/{taskObjectId}",
     *      operationId="deleteTaskObjectRequest",
     *      tags={"Task object"},
     *      summary="Delete the task object",
     *      description="Returns task object data",
     *      @OA\Parameter(
     *         name="taskObjectId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
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
     *                  example={{
     *                     "id": 4
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *
     *                  )
     *              ),
     *          ),
     *       ),
     *      @OA\Response(
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
     *      )
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->responseSuccess(['id' => $id]);
    }
}
