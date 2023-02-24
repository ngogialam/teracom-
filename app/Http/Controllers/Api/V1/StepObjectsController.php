<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Prettus\Validator\Contracts\ValidatorInterface;
use App\Http\Requests\StepObjectCreateRequest;
use App\Http\Requests\StepObjectUpdateRequest;
use App\Services\StepObjectService;
use App\Validators\StepObjectValidator;
use Illuminate\Http\JsonResponse;

/**
 * Class StepObjectsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class StepObjectsController extends BaseController
{
    /**
     * StepObjectsController constructor.
     *
     * @param StepObjectValidator $validator
     * @param StepObjectService $service
     */
    public function __construct(
        protected StepObjectValidator $validator,
        protected StepObjectService $service
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $stepObjects = $this->service->all();
        return $this->responseSuccess($stepObjects);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/step-object",
     *      operationId="storeStepObject",
     *      tags={"StepObject"},
     *      summary="Store new step object",
     *      description="Returns step object data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StepObjectCreateRequest")
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
     *
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  example={{
     *                  "step_id": 1,
     *                  "object_action_type": 2,
     *                  "object_type": 5,
     *                  "object_id": 1,
     *                  "object_name": "name deparment 1",
     *                  "object_position": "user 1",
     *                  "created_at": "1872600",
     *                  "status": 1,
     *                  "active":0,
     *                  "process_id": 1
     *                }, {
     *                  "step_id": 1,
     *                  "object_action_type": 2,
     *                  "object_type": 5,
     *                  "object_id": 1,
     *                  "object_name": "name deparment 2",
     *                  "object_position": "user 2",
     *                  "created_at": "1872600",
     *                  "status": 1,
     *                  "active":0,
     *                  "process_id": 1
     *                }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/StepObjectPresenter"
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
     * @param  StepObjectCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(StepObjectCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(StepObjectValidator::RULE_CREATE);

        $this->service->store($request->all());
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
        $stepObject = $this->service->show($id);

        return $this->responseSuccess($stepObject['data']);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/step-object/{stepObjectId}",
     *      operationId="updateStepObject",
     *      tags={"StepObject"},
     *      summary="Update StepObject",
     *      description="Returns StepObject data",
     *      @OA\Parameter(
     *         name="stepObjectId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StepObjectUpdateRequest")
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
     *                      ref="#/components/schemas/StepObject"
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
     * @param  StepObjectUpdateRequest $request
     * @param  string            $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(StepObjectUpdateRequest $request, int $id): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

        $stepObject = $this->service->update($request->all(), $id);

        return $this->responseSuccess($stepObject['data']);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/step-object/{stepObjectId}",
     *      operationId="deleteStepObject",
     *      tags={"StepObject"},
     *      summary="Delete StepObject",
     *      description="Returns StepObject id",
     *      @OA\Parameter(
     *         name="stepObjectId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
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
     *                      "id": 1
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/StepObject"
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
     *)
     *
     * Remove the specified resource from storage.
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
