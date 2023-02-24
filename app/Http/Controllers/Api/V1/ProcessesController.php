<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\DuplicateException;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ProcessCreateRequest;
use App\Http\Requests\ProcessUpdateRequest;
use App\Validators\ProcessValidator;
use App\Services\ProcessesService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class ProcessesController.
 *
 * @package namespace App\Http\Controllers\Api;
 */
class ProcessesController extends BaseController
{
    /**
     * ProcessesController constructor.
     *
     * @param ProcessesService $service
     * @param ProcessValidator $validator
     */
    public function __construct(
        protected ProcessesService $service,
        protected ProcessValidator $validator
    ) {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/v1/process",
     *     operationId="getProcesList",
     *     tags={"Process"},
     *     summary="Get list of process OR get list of process send to me",
     *     description="Returns list of process OR get list of process send to me",
     *      @OA\Parameter(
     *          required=false,
     *          description = "page of list process",
     *          in="query",
     *          name="page",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          description = "limit of list process",
     *          in="query",
     *          name="limit",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          description = "parameter get list of process",
     *          in="query",
     *          name="created_by",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="name",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *          @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="process_code",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *          @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="auth_do_first_step",
     *          @OA\Schema(
     *              type="bool"
     *          )
     *      ),
     *          @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="approval_status",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="owner_deparment_id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="request_completion_time_start",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *       @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="request_completion_time_end",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="activation_date_start",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="query",
     *          name="activation_date_end",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          description = "parameter get list of process send to me",
     *          in="query",
     *          name="user_id",
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
     *                  "count": {
     *                      "daft": 1,
     *                      "waiting": 1,
     *                      "active": 1,
     *                      "expire": 1
     *                  },
     *                  0:{
     *                  "id": 1,
     *                  "code": "ABC123",
     *                  "name": "A nice process",
     *                  "short_name": "process",
     *                  "owner_deparment_id": 1,
     *                  "target_apply_type": 1,
     *                  "regulation_document": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                  "regulation_start_date": 1655002163,
     *                  "regulation_end_date": 1655002163,
     *                  "description": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                  "approval_status": 1,
     *                  "approval_target_type": 1,
     *                  "version": 1,
     *                  "created_by": 3782482159,
     *                  "updated_by": 3782482159,
     *                  "status": "1",
     *                }, 1:{
     *                  "id": 2,
     *                  "code": "ABC1234",
     *                  "name": "A nice process 1",
     *                  "short_name": "process 1",
     *                  "owner_deparment_id": 1,
     *                  "target_apply_type": 1,
     *                  "regulation_document": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                  "regulation_start_date": 1655002163,
     *                  "regulation_end_date": 1655002163,
     *                  "description": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                  "approval_status": 1,
     *                  "approval_target_type": 1,
     *                  "version": 1,
     *                  "created_by": 3782482159,
     *                  "updated_by": 3782482159,
     *                  "status": "1",
     *                },2: {
     *                  "id": 12,
     *                  "code": "342A",
     *                  "name": "No name",
     *                  "short_name": "Nn",
     *                  "owner_deparment_id": 2,
     *                  "target_apply_type": 3,
     *                  "regulation_document": "no ndfgdhasjk jfsjafbsds  adbhsf",
     *                  "regulation_start_date": 2255022163,
     *                  "regulation_end_date": 1345442163,
     *                  "description": "af;bsvj agdasgfcywfyc ",
     *                  "approval_status": 2,
     *                  "approval_target_type": 1,
     *                  "version": 1,
     *                  "created_by": 3782482159,
     *                  "updated_by": 3782482159,
     *                  "status": "0",
     *                },
     * },
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/Process"
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
        $processes = $this->service->all($request->all());
        return $this->responseSuccess($processes);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/process",
     *      operationId="storeProcess",
     *      tags={"Process"},
     *      summary="Store new process",
     *      description="Returns process data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProcessCreateRequest")
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
     *                      ref="#/components/schemas/Process"
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
     * @param  ProcessCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */

    public function store(ProcessCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(ProcessValidator::RULE_CREATE);

        $process = $this->service->create($request->all());

        return $this->show($process['data']['id']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/process/{processId}",
     *    tags={"Process"},
     *     summary="Get process by process id",
     *     operationId="getProcessById",
     *     description="Returns a single process.",
     *     @OA\Parameter(
     *         name="processId",
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
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/Process"
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
        $process = $this->service->show($id);
        return $this->responseSuccess([$process['data']]);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/process/{processId}",
     *      operationId="updateProcess",
     *      tags={"Process"},
     *      summary="Update process",
     *      description="Returns process data",
     *      @OA\Parameter(
     *         name="processId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProcessUpdateRequest")
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
     *                      ref="#/components/schemas/Process"
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
     * @param  ProcessUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProcessUpdateRequest $request, int $id): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(ProcessValidator::RULE_UPDATE);

        $process = $this->service->update($request->all(), $id);

        return $this->show($process['data']['id']);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/process/{id}",
     *      operationId="destroyProcess",
     *      tags={"Process"},
     *      summary="Delete process",
     *      description="Returns Deleted process data",
     *      @OA\Parameter(
     *         name="id",
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
     *                      ref="#/components/schemas/Process"
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

        return $this->responseSuccess(["id" => $id]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkProcessShortName(Request $request): JsonResponse
    {
        $isDuplicate = $this->service->isDuplicateShortName(abandonNulValue($request->all()));

        if ($isDuplicate) {
            throw new DuplicateException("Short name is already exists");
        }
        return $this->responseSuccess([]);
    }
}
