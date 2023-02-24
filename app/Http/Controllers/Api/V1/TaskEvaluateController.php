<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Http\Requests\TaskEvaluateCreateRequest;
use App\Http\Requests\TaskEvaluateUpdateRequest;
use App\Validators\TaskEvaluateValidator;
use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use App\Services\TaskEvaluateService;

/**
 * Class TaskEvaluateController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class TaskEvaluateController extends BaseController
{
    /**
     * TasksController constructor.
     *
     * @param TaskEvaluateValidator $validator
     * @param TaskEvaluateService $service
     */
    public function __construct(
        protected TaskEvaluateValidator $validator,
        protected TaskEvaluateService $service
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $taskEvaluate = $this->service->all($request->all());
        return $this->responseSuccess($taskEvaluate['data']);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/task-evaluate",
     *      operationId="storeTaskEvaluateRequest",
     *      tags={"Task evaluat"},
     *      summary="Store new task evaluate",
     *      description="Returns task evaluate data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaskEvaluateCreateRequest")
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
     *                             "task_id": 6,
     *                             "process_id": 1,
     *                             "step_id": 2,
     *                             "rate": 1,
     *                             "comment": "aaaaaa",
     *                             "created_at": 1222433,
     *                             "updated_at": 1222433,
     *                             "deleted_at": 1234433,
     *                             "created_by": 1233223,
     *                             "updated_by": 14
     *                            },
     *                            {
     *                             "task_id": 7,
     *                             "process_id": 1,
     *                             "step_id": 2,
     *                             "rate": 1,
     *                             "comment": "no comment",
     *                             "created_at": 1223333,
     *                             "updated_at": 1223333,
     *                             "deleted_at": 1233333,
     *                             "created_by": 1233333,
     *                             "updated_by": 13
     *                             },
     *                           },
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
     * @param  TaskEvaluateCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TaskEvaluateCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(TaskEvaluateValidator::RULE_CREATE);

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
        $taskEvaluate = $this->service->show($id);

        return $this->responseSuccess($taskEvaluate);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  TaskEvaluateUpdateRequest $request
     * @param  int $id
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskEvaluateUpdateRequest $request, int $id): JsonResponse
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
