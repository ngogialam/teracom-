<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ProcessStepChildCreateRequest;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Http\Requests\ProcessStepCreateRequest;
use App\Http\Requests\ProcessStepUpdateRequest;
use App\Services\ProcessStepsService;
use App\Validators\ProcessStepValidator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class ProcessStepsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class ProcessStepsController extends BaseController
{
    /**
     * ProcessStepsController constructor.
     *
     * @param ProcessStepsService $service
     * @param ProcessStepValidator $validator
     */
    public function __construct(
        protected ProcessStepValidator $validator,
        protected ProcessStepsService $service
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $processSteps = $this->service->all($request->all());
        return $this->responseSuccess($processSteps);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/process-step",
     *      operationId="storeProcessStep",
     *      tags={"Process Step"},
     *      summary="Store first process step",
     *      description="Returns first process step data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProcessStepCreateRequest")
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
     *                  "id": 1,
     *                  "name": "New process step",
     *                  "action_type": "1",
     *                  "step_type": "1",
     *                  "step_order": "1",
     *                  "child_process_id": "1",
     *                  "child_process_id": "1",
     *                  "sla_quantity": "1",
     *                  "child_process_id": "1",
     *                  "sla_unit": "1",
     *                  "transfer_condition_type": "1",
     *                  "created_by": "1",
     *                  "created_at": "1872600",
     *                  "updated_at": "1872600",
     *                  "updated_by": "1872600",
     *                  "status": "1",
     *                  "deleted_at": null,
     *                  "timesheet": 1
     *                }, {
     *                   "id": 2,
     *                  "name": "New process step",
     *                  "action_type": "1",
     *                  "step_type": "1",
     *                  "step_order": "1",
     *                  "child_process_id": "1",
     *                  "child_process_id": "1",
     *                  "sla_quantity": "1",
     *                  "child_process_id": "1",
     *                  "sla_unit": "1",
     *                  "transfer_condition_type": "1",
     *                  "created_by": "1",
     *                  "created_at": "1872600",
     *                  "updated_at": "1872600",
     *                  "updated_by": "1872600",
     *                  "status": "1",
     *                  "deleted_at": null,
     *                  "timesheet": 1
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/ProcessStepPresenter"
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
     * @param  ProcessStepCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */

    public function store(ProcessStepCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(ProcessStepValidator::RULE_CREATE);

        $processStep = $this->service->create($request->all());

        return $this->show($processStep['data']['id']);
    }

     /**
     * @OA\get(
     *      path="/api/v1/process-step/{processStepId}",
     *      operationId="showProcessStep",
     *      tags={"Process Step"},
     *      summary="Show process step",
     *      description="Show process step data",
     *      @OA\Parameter(
     *         name="processStepId",
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
     *                  "id": 1,
     *                  "name": "New process step",
     *                  "action_type": "1",
     *                  "step_type": "1",
     *                  "step_order": "1",
     *                  "child_process_id": "1",
     *                  "child_process_id": "1",
     *                  "sla_quantity": "1",
     *                  "child_process_id": "1",
     *                  "sla_unit": "1",
     *                  "transfer_condition_type": "1",
     *                  "created_by": "1",
     *                  "created_at": "1872600",
     *                  "updated_at": "1872600",
     *                  "updated_by": "1872600",
     *                  "status": "1",
     *                  "deleted_at": null,
     *                  "timesheet": 1
     *                }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/ProcessStepPresenter"
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
        $processStep = $this->service->show($id);

        return $this->responseSuccess([$processStep['data']]);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/process-step/{processStepId}",
     *      operationId="updateProcessStep",
     *      tags={"Process Step"},
     *      summary="Update process step",
     *      description="Returns process step data",
     *      @OA\Parameter(
     *         name="processStepId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProcessStepUpdateRequest")
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
     *                  "id": 1,
     *                  "name": "New process step",
     *                  "action_type": "1",
     *                  "step_type": "1",
     *                  "step_order": "1",
     *                  "child_process_id": "1",
     *                  "child_process_id": "1",
     *                  "sla_quantity": "1",
     *                  "child_process_id": "1",
     *                  "sla_unit": "1",
     *                  "transfer_condition_type": "1",
     *                  "created_by": "1",
     *                  "created_at": "1872600",
     *                  "updated_at": "1872600",
     *                  "updated_by": "1872600",
     *                  "status": "1",
     *                  "deleted_at": null,
     *                  "timesheet": 1
     *                }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/ProcessStepPresenter"
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
     * @param  ProcessStepUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProcessStepUpdateRequest $request, int $id): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

        $this->service->update($request->all(), $id);

        return $this->show($id);
    }

     /**
     * @OA\delete(
     *      path="/api/v1/process-step/{processStepId}",
     *      operationId="deleteProcessStep",
     *      tags={"Process Step"},
     *      summary="Delete process step",
     *      description="delete process step data",
     *      @OA\Parameter(
     *         name="processStepId",
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
     *                  "id": 1
     *                }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/ProcessStepPresenter"
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
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return $this->responseSuccess(['id' => $id]);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/process-step-child",
     *      operationId="storeProcessStepChild",
     *      tags={"Process Step"},
     *      summary="Store process step child",
     *      description="Returns process step child data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProcessStepChildCreateRequest")
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
     *                  "id": 1,
     *                  "name": "New process step",
     *                  "action_type": "1",
     *                  "step_type": "1",
     *                  "step_order": "1",
     *                  "child_process_id": "1",
     *                  "child_process_id": "1",
     *                  "sla_quantity": "1",
     *                  "child_process_id": "1",
     *                  "sla_unit": "1",
     *                  "transfer_condition_type": "1",
     *                  "created_by": "1",
     *                  "created_at": "1872600",
     *                  "updated_at": "1872600",
     *                  "updated_by": "1872600",
     *                  "status": "1",
     *                  "deleted_at": null,
     *                  "timesheet": 1
     *                }, {
     *                   "id": 2,
     *                  "name": "New process step",
     *                  "action_type": "1",
     *                  "step_type": "1",
     *                  "step_order": "1",
     *                  "child_process_id": "1",
     *                  "child_process_id": "1",
     *                  "sla_quantity": "1",
     *                  "child_process_id": "1",
     *                  "sla_unit": "1",
     *                  "transfer_condition_type": "1",
     *                  "created_by": "1",
     *                  "created_at": "1872600",
     *                  "updated_at": "1872600",
     *                  "updated_by": "1872600",
     *                  "status": "1",
     *                  "deleted_at": null,
     *                  "timesheet": 1
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/ProcessStepPresenter"
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
     * @param  ProcessStepChildCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeChild(ProcessStepChildCreateRequest $request): JsonResponse
    {
        $params = $request->all();
        $this->validator->with($params)->passesOrFail(ProcessStepValidator::RULE_CREATE);

        $processStep = $this->service->create($params);
        if (!empty($request['file_attachment_ids'])) {
            $this->service->attachment($processStep['data']['id'], $request['file_attachment_ids']);
        }
        return $this->show($processStep['data']['id']);
    }
}
