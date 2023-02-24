<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Http\Requests\TaskTimesheetCreateRequest;
use App\Http\Requests\TaskTimesheetUpdateRequest;
use App\Services\TaskTimesheetService;
use App\Validators\TaskTimesheetValidator;
use Illuminate\Http\JsonResponse;

/**
 * Class TaskTimesheetsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class TaskTimesheetsController extends BaseController
{
    /**
     * TaskTimesheetsController constructor.
     *
     * @param TaskTimesheetService $service
     * @param TaskTimesheetValidator $validator
     */
    public function __construct(
        protected TaskTimesheetValidator $validator,
        protected TaskTimesheetService $service
    ) {
    }

    /**
     * @OA\Get(
     *      path="/api/v1/task-timesheet",
     *      operationId="getTaskTimesheetRequest",
     *      tags={"Task timesheet"},
     *      summary="get list task timesheet",
     *      description="Returns list task timesheet data",
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
     *                     "id": 1,
     *                     "work_time": 1656338245,
     *                     "number_working": 1656338245,
     *                     "number_actual_time": 1656338245,
     *                     "note": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                     "created_at": 1656338245,
     *                     "updated_at": 1656338245,
     *                     "deleted_at": null,
     *                     "created_by": 1656338245,
     *                     "updated_by": 1656338245,
     *                     "process_id": 1,
     *                  }, {
     *                     "id": 2,
     *                     "work_time": 1656338245,
     *                     "number_working": 1656338245,
     *                     "number_actual_time": 1656338245,
     *                     "note": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                     "created_at": 1656338245,
     *                     "updated_at": 1656338245,
     *                     "deleted_at": null,
     *                     "created_by": 1656338245,
     *                     "updated_by": 1656338245,
     *                     "process_id": 1,
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/TaskTimesheetPresenter"
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
    public function index(): JsonResponse
    {
        $taskTimeSheets = $this->service->all();
        return $this->responseSuccess([$taskTimeSheets]);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/task-timesheet",
     *      operationId="storeTaskTimesheetRequest",
     *      tags={"Task timesheet"},
     *      summary="Store new task timesheet",
     *      description="Returns task timesheet data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaskTimesheetCreateRequest")
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
     *                     "id": 1,
     *                     "work_time": 1656338245,
     *                     "number_working": 1656338245,
     *                     "number_actual_time": 1656338245,
     *                     "note": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                     "created_at": 1656338245,
     *                     "updated_at": 1656338245,
     *                     "created_by": 1656338245,
     *                     "updated_by": 1656338245,
     *                     "process_id": 1,
     *                  }, {
     *                     "id": 2,
     *                     "work_time": 1656338245,
     *                     "number_working": 1656338245,
     *                     "number_actual_time": 1656338245,
     *                     "note": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                     "created_at": 1656338245,
     *                     "updated_at": 1656338245,
     *                     "created_by": 1656338245,
     *                     "updated_by": 1656338245,
     *                     "process_id": 2,
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/TaskTimesheetPresenter"
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
     * @param  TaskTimesheetCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */

    public function store(TaskTimesheetCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(TaskTimesheetValidator::RULE_CREATE);

        $this->service->create($request->all());

        return $this->responseSuccess($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $taskTimesheet = $this->service->show($id);

        return $this->responseSuccess($taskTimesheet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TaskTimesheetUpdateRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function update(TaskTimesheetUpdateRequest $request, int $id): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $this->service->update($request->all(), $id);

        return $this->show($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->responseSuccess(["id" => $id]);
    }
}
