<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StepTransferConditionCreateRequest;
use App\Http\Requests\StepTransferConditionUpdateRequest;
use App\Validators\StepTransferConditionValidator;
use Illuminate\Http\JsonResponse;
use App\Services\StepTransferConditionService;
use Illuminate\Http\Request;

/**
 * Class StepTransferConditionsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class StepTransferConditionsController extends BaseController
{
    /**
     * StepTransferConditionsController constructor.
     *
     * @param StepTransferConditionService $service
     * @param StepTransferConditionValidator $validator
     */
    public function __construct(
        protected StepTransferConditionValidator $validator,
        protected StepTransferConditionService $service,
    ) {
        //
    }

    /**
     * Get list step transfer condition by $request
     * @OA\Get(
     *      path="/api/v1/step-transfer-condition",
     *      operationId="GetStepTransferCondition",
     *      tags={"Step transfer conditions"},
     *      summary="Get Step transfer conditions",
     *      description="Returns get step transfer conditions",
     *      @OA\Parameter(
     *          required=true,
     *          in="query",
     *          name="step_id",
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
     *                      "id": 1,
     *                      "step_id": 9,
     *                      "step_condition": 1,
     *                      "step_order": 2,
     *                      "next_step_type": 1,
     *                      "group_condition_id": null,
     *                      "created_at": "1872600",
     *                      "deleted_at": null,
     *                      "stepGroupConndition": null
     *                  },
     *                  {
     *                      "id": 2,
     *                      "step_id": 9,
     *                      "step_condition": 1,
     *                      "step_order": 3,
     *                      "next_step_type": 1,
     *                      "group_condition_id": null,
     *                      "created_at": null,
     *                      "deleted_at": null,
     *                      "stepGroupConndition": null
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
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $stepTransferConditions = $this->service->all($request->all());
        return $this->responseSuccess($stepTransferConditions['data']);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/step-transfer-condition",
     *      operationId="StepTransferCondition",
     *      tags={"Step transfer conditions"},
     *      summary="Store first Step transfer conditions",
     *      description="Returns first step transfer conditions",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StepTransferConditionCreateRequest")
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
     *                  "step_id": 1,
     *                  "step_condition": 1,
     *                   "step_order": 1,
     *                  "next_step_type": 1,
     *                  "group_condition_id": 1,
     *                  "created_at": 1872600,
     *                  "deleted_at": 1872600
     *                }, {
     *                 "id": 2,
     *                  "step_id": 1,
     *                  "step_condition": 1,
     *                   "step_order": 1,
     *                  "next_step_type": 1,
     *                  "group_condition_id": 1,
     *                  "created_at": 1872600,
     *                  "deleted_at": 1872600
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
     * @param  StepTransferConditionCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */

    public function store(StepTransferConditionCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(StepTransferConditionValidator::RULE_CREATE);
        $stepTransferCondition = $this->service->create($request->all());

        return $this->responseSuccess([$stepTransferCondition['data']]);
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
        $stepTransferCondition = $this->service->show($id);

        return $this->responseSuccess($stepTransferCondition['data']);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/step-transfer-condition/{stepTransferConditionId}",
     *      tags={"Step transfer conditions"},
     *      summary="Update first Step transfer conditions",
     *      description="Returns first step transfer conditions",
     *      @OA\Parameter(
     *         name="stepTransferConditionId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StepTransferConditionUpdateRequest")
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
     *                  "step_id": 1,
     *                  "step_condition": 1,
     *                   "step_order": 1,
     *                  "next_step_type": 1,
     *                  "group_condition_id": 1,
     *                  "created_at": 1872600,
     *                  "deleted_at": 1872600
     *                }, {
     *                 "id": 2,
     *                  "step_id": 1,
     *                  "step_condition": 1,
     *                   "step_order": 1,
     *                  "next_step_type": 1,
     *                  "group_condition_id": 1,
     *                  "created_at": 1872600,
     *                  "deleted_at": 1872600
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
     * @param  StepTransferConditionUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(StepTransferConditionUpdateRequest $request, int $id): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(StepTransferConditionValidator::RULE_UPDATE);

        $this->service->update($request->all(), $id);

        return $this->show($id);
    }


    /**
     * Remove the specified resource from storage.
     * @OA\Delete(
     *      path="/api/v1/step-transfer-condition/{stepTransferConditionId}",
     *      tags={"Step transfer conditions"},
     *      summary="Delete Step transfer conditions",
     *      description="Returns Delete step transfer conditions",
     *      @OA\Parameter(
     *         name="stepTransferConditionId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
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
     *                  example={
     *                      "id": 2
     *                  },
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
