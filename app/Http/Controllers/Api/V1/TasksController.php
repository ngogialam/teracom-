<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Repositories\TaskRepositoryInterface;
use App\Services\TaskService;
use App\Validators\TaskValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

/**
 * Class TasksController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class TasksController extends BaseController
{
    /**
     * TasksController constructor.
     *
     * @param TaskRepositoryInterface $repository
     * @param TaskValidator $validator
     * @param TaskService $service
     */
    public function __construct(
        protected TaskRepositoryInterface $repository,
        protected TaskValidator $validator,
        protected TaskService $service
    ) {
    }

    /**
     * @OA\Get(
     *      path="/api/v1/tasks",
     *      operationId="GetListTask",
     *      tags={"Task"},
     *      summary="get list task",
     *      description="Returns list task data",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="assignee_id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="nameProcessOrCodeTicket",
     *          description="Tìm kiếm theo mã phiếu, tên quy trình",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="owner_deparment_id",
     *          description="Đơn vị làm việc(Tìm kiếm theo quy trình)",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="version",
     *          description="Version(Tìm kiếm theo quy trình)",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="nameOrCode",
     *          description="Mã hoặc tên quy trình(Tìm kiếm theo quy trình)",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="request_completion_time_start",
     *          description="Thời gian yêu cầu hoàn thành(Tìm kiếm theo quy trình)",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="request_completion_time_end",
     *          description="Thời gian yêu cầu hoàn thành(Tìm kiếm theo quy trình)",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="approval_status",
     *          description="Trạng thái quy trình(Tìm kiếm theo quy trình)",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="object_id",
     *          description="Người xử lý hoặc nhận thông tin(Tìm kiếm theo nhiệm vụ)",
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
     *                example={
     *                      {
     *                 "id": 1,
     *                 "ticket_req_id": 1,
     *                 "step_id": 1,
     *                 "task_type": 1,
     *                 "assignee_id": 1,
     *                 "department_id": 1,
     *                 "department_id": 1,
     *                 "actual_completed_time": null,
     *                 "actual_time": 13141,
     *                 "action": 1,
     *                 "approval_status": 1,
     *                 "rollback_step_id": 1,
     *                 "rollback_type": 2,
     *                 "comment": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                 "status": 1,
     *                 "auto_ticket_req_id": null,
     *                 "process": null,
     *                 "processStep": {
     *                     "id": 1,
     *                     "process_id": 1,
     *                     "name": "ffff",
     *                     "action_type": 1,
     *                     "step_type": 1,
     *                     "step_order": 1,
     *                     "child_process_id": 1,
     *                     "sla_quantity": 1,
     *                     "sla_unit": 1,
     *                     "transfer_condition_type": 1,
     *                     "created_by": 1,
     *                     "created_at": 1,
     *                     "updated_at": 1,
     *                     "updated_by": 1,
     *                     "status": 1,
     *                     "deleted_at": 1,
     *                     "timesheet": 0
     *                                 },
     *                 "tickectRequest": {
     *                     "id": 1,
     *                     "name": "A nice ticket request",
     *                     "department_id": 1,
     *                     "process_id": 1,
     *                     "ticket_serial": "f",
     *                     "request_time": 1655002163,
     *                     "finish_time": 1655002163,
     *                     "priority": 1,
     *                     "comment": "null",
     *                     "ticket_action": 1,
     *                     "approval_status": 1,
     *                     "created_by": 1234567890,
     *                     "created_at": 1234567890,
     *                     "updated_at": 1234567890,
     *                     "updated_by": 1234567890,
     *                     "deleted_at": 1656640268
     *                                    }
     *                             },
     *                             {
     *                 "id": 2,
     *                 "ticket_req_id": 1,
     *                 "step_id": 2,
     *                 "task_type": 1,
     *                 "assignee_id": 1,
     *                 "department_id": 1,
     *                 "actual_completed_time": null,
     *                 "actual_time": 3,
     *                 "action": 1,
     *                 "approval_status": 1,
     *                 "rollback_step_id": 2,
     *                 "rollback_type": 1,
     *                 "comment": "ưqregegwgwgwgwrgwrtg",
     *                 "status": 1,
     *                 "auto_ticket_req_id": null,
     *                 "process": null,
     *                 "processStep": {
     *                      "id": 2,
     *                      "process_id": 2,
     *                      "name": "dfd",
     *                      "action_type": 2,
     *                      "step_type": 2,
     *                      "step_order": 2,
     *                      "child_process_id": 2,
     *                      "sla_quantity": 1,
     *                      "sla_unit": 1,
     *                      "transfer_condition_type": 1,
     *                      "created_by": 1,
     *                      "created_at": 1,
     *                      "updated_at": 1,
     *                      "updated_by": 1,
     *                      "status": 1,
     *                      "deleted_at": 1,
     *                      "timesheet": 0
     *                                 },
     *                  "tickectRequest": {
     *                     "id": 1,
     *                     "name": "A nice ticket request",
     *                     "department_id": 1,
     *                     "process_id": 1,
     *                     "ticket_serial": "f",
     *                     "request_time": 1655002163,
     *                     "finish_time": 1655002163,
     *                     "priority": 1,
     *                     "comment": "null",
     *                     "ticket_action": 1,
     *                     "approval_status": 1,
     *                     "created_by": 1234567890,
     *                     "created_at": 1234567890,
     *                     "updated_at": 1234567890,
     *                     "updated_by": 1234567890,
     *                     "deleted_at": 1656640268
     *                                     },
     *                     },
     *        },
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = $this->service->all($request->all());
        return $this->responseSuccess($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TaskCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TaskCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

        $task = $this->service->create($request->all());

        return $this->responseSuccess($task);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/tasks/{taskId}",
     *      operationId="GetTask",
     *      tags={"Task"},
     *      summary="get task",
     *      description="Returns task data",
     *      @OA\Parameter(
     *         name="taskId",
     *         in="path",
     *         description="Task that to be list",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *
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
     *                example={
     *                      "id": 1,
     *                      "ticket_req_id": 1,
     *                      "step_id": 46,
     *                      "task_type": 1,
     *                      "assignee_id": 1,
     *                      "department_id": 1,
     *                      "actual_completed_time": 14545265,
     *                      "actual_time": 14552336,
     *                      "action": 2,
     *                      "approval_status": 1,
     *                      "rollback_step_id": 46,
     *                      "rollback_type": 1,
     *                      "comment": "aaaaaaaaaaaaaaaa",
     *                      "created_by": 1,
     *                      "created_at": 1212545212,
     *                      "updated_at": 1212545212,
     *                      "updated_by": 1,
     *                      "updated_by": 1,
     *                      "status": 1,
     *        },
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
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $task = $this->service->show($id);
        $task['data']['fileAttachments'] = $this->service->getFileAttachment($id);

        foreach ($task['data'] as $key => $tasks) {
            $task['data']['name'] = Str::random(7);
        }
        return $this->responseSuccess($task['data']);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/tasks/{taskId}",
     *      operationId="updateTask",
     *      tags={"Task"},
     *      summary="update task",
     *      description="Returns task data",
     *      @OA\Parameter(
     *         name="taskId",
     *         in="path",
     *         description="Task that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaskUpdateRequest")
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
     *                example={
     *                     "id": 1,
     *                      "ticket_req_id": 1,
     *                      "step_id": 46,
     *                      "task_type": 1,
     *                      "assignee_id": 1,
     *                      "department_id": 1,
     *                      "actual_complete_time": 14545265,
     *                      "expected_complete_time": 14552336,
     *                      "action": 2,
     *                      "approval_status": 1,
     *                      "rollback_step_id": 46,
     *                      "rollback_type": 1,
     *                      "comment": "aaaaaaaaaaaaaaaa",
     *                      "created_by": 1,
     *                      "created_at": 1212545212,
     *                      "updated_at": 1212545212,
     *                      "updated_by": 1,
     *                      "updated_by": 1,
     *                      "status": 1,
     *                  },
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
     * @param  TaskUpdateRequest $request
     * @param  string            $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TaskUpdateRequest $request, $id): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $task = $this->service->update($request->all(), $id);

        return $this->show($task['data']['id']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->service->delete($id);

        return $this->responseSuccess(["id" => $id]);
    }
}
