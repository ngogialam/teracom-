<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StepGroupConditionCreateRequest;
use App\Http\Requests\StepGroupConditionUpdateRequest;
use App\Validators\StepGroupConditionValidator;
use Illuminate\Http\JsonResponse;
use App\Services\StepGroupConditionService;
use Illuminate\Http\Request;

/**
 * Class StepGroupConditionsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class StepGroupConditionsController extends BaseController
{
    /**
     * StepGroupConditionsController constructor.
     *
     * @param StepGroupConditionService $service
     * @param StepGroupConditionValidator $validator
     */
    public function __construct(
        protected StepGroupConditionValidator $validator,
        protected StepGroupConditionService $service
    ) {
        //
    }

    /**
     * Get list step group condition by $request
     * @OA\Get(
     *     path="/api/v1/step-group-condition",
     *     operationId="stepGroupConditionList",
     *     tags={"Step Group Condition"},
     *     summary="List Step Group Condition",
     *     description="Returns List Step Group Condition",
     *      @OA\Parameter(
     *          required=false,
     *          description = "group_condition_id of step group condition",
     *          in="query",
     *          name="group_condition_id",
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
     *                  "id": 1,
     *                  "group_first_step": 1,
     *                  "step_condition": 1,
     *                  "step_order": 1,
     *                   "created_at": null,
     *                  "deleted_at": null
     *                }, {
     *                   "id": 1,
     *                  "group_first_step": 1,
     *                  "step_condition": 1,
     *                  "step_order": 1,
     *                   "created_at": null,
     *                  "deleted_at": null
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/ProcessStepPresenter"
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
        $stepGroupConditions = $this->service->all($request->all());
        return $this->responseSuccess($stepGroupConditions['data']);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/step-group-condition",
     *      operationId="StepGroupCondition",
     *      tags={"Step Group Condition"},
     *      summary="Store first Step Group Condition",
     *      description="Returns Step Group Condition data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StepGroupConditionCreateRequest")
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
     *                  "group_first_step": 1,
     *                  "step_condition": 1,
     *                  "step_order": 1,
     *                   "created_at": null,
     *                  "deleted_at": null
     *                }, {
     *                   "id": 1,
     *                  "group_first_step": 1,
     *                  "step_condition": 1,
     *                  "step_order": 1,
     *                   "created_at": null,
     *                  "deleted_at": null
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
     * @param  StepGroupConditionCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(StepGroupConditionCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(StepGroupConditionValidator::RULE_CREATE);

        $stepGroup = $this->service->create($request->all());

        return $this->responseSuccess([$stepGroup['data']]);
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
        $stepGroup = $this->service->show($id);

        return $this->responseSuccess($stepGroup['data']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StepGroupConditionUpdateRequest $request
     * @param  int            $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(StepGroupConditionUpdateRequest $request, int $id): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(StepGroupConditionValidator::RULE_UPDATE);

        $stepGroup = $this->service->update($request->all(), $id);

        return $this->responseSuccess($stepGroup['data']);
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

        return $this->responseSuccess(['id' => $id]);
    }
}
