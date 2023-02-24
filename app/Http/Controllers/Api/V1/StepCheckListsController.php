<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StepCheckListCreateRequest;
use App\Http\Requests\StepCheckListUpdateRequest;
use App\Validators\StepCheckListValidator;
use App\Services\StepCheckListService;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class StepCheckListsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class StepCheckListsController extends BaseController
{

    /**
     * StepCheckListsController constructor.
     *
     * @param StepCheckListService $service
     * @param StepCheckListValidator $validator
     */
    public function __construct(
        protected StepCheckListValidator $validator,
        protected StepCheckListService $service
    ) {
    }

    /**
     * @OA\Post(
     *      path="/api/v1/step-check-list",
     *      operationId="storeStepCheckList",
     *      tags={"Process Step"},
     *      summary="Store new step-check-list",
     *      description="Returns step-check-list data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StepCheckListCreateRequest")
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
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/StepChecklist"
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
     * @param StepCheckListCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(StepCheckListCreateRequest $request): JsonResponse
    {
        $steps = $this->service->store($request->all());
        return $this->responseSuccess($steps);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/step-check-list/{Id}",
     *      operationId="updateStepCheckList",
     *      tags={"StepCheckList"},
     *      summary="update stepchecklist",
     *      description="Returns setep checklist data",
     *      @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         description="Step Checklist that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StepCheckListUpdateRequest")
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
     *
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
     * @param StepCheckListUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(StepCheckListUpdateRequest $request, int $id): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
        $this->service->update($request->all(), $id);

        return $this->responseSuccess($request->all());
    }
}
