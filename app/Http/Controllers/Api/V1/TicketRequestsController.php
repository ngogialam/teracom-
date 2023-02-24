<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\TicketRequestCreateRequest;
use App\Http\Requests\TicketRequestUpdateRequest;
use App\Repositories\TicketRequestRepositoryInterface;
use App\Services\TicketRequestService;
use App\Validators\TicketRequestValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class TicketRequestsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class TicketRequestsController extends BaseController
{
    /**
     * TicketRequestsController constructor.
     *
     * @param TicketRequestRepositoryInterface $repository
     * @param TicketRequestValidator $validator
     */
    public function __construct(
        protected TicketRequestRepositoryInterface $repository,
        protected TicketRequestValidator $validator,
        protected TicketRequestService $service
    ) {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/v1/ticket-request",
     *     operationId="getTicketRequestList",
     *     tags={"Ticket request"},
     *     summary="Get list of ticket request",
     *     description="Returns list of ticket request",
     *      @OA\Parameter(
     *          required=true,
     *          in="query",
     *          name="created_by",
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
     *                example={{
     *                  "id": 1,
     *                  "name": "A nice ticket request",
     *                  "deparment_id": 1,
     *                  "process_id": 1,
     *                  "ticket_serial": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                  "request_time": 1655002163,
     *                  "finish_time": 1655002163,
     *                  "priority": 1,
     *                  "comment": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                  "ticket_action": 1,
     *                  "approval_status": 1,
     *                  "created_by": 1234567890,
     *                  "created_at": 1234567890,
     *                  "updated_at": 1234567890,
     *                  "updated_by": 1234567890,
     *                  "delete_at":null,
     *                }, {
     *                  "id": 2,
     *                  "name": "A nice ticket request 1",
     *                  "deparment_id": 1,
     *                  "process_id": 1,
     *                  "ticket_serial": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                  "request_time": 1655002163,
     *                  "finish_time": 1655002163,
     *                  "priority": 1,
     *                  "comment": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                  "ticket_action": 1,
     *                  "approval_status": 1,
     *                  "created_by": 1234567890,
     *                  "created_at": 1234567890,
     *                  "updated_at": 1234567890,
     *                  "updated_by": 1234567890,
     *                  "delete_at":null,
     *                }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/TicketRequestPresenter"
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
        $ticketRequests = $this->service->all($request->all());
        return $this->responseSuccess($ticketRequests);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/ticket-request",
     *      operationId="storeTicketRequest",
     *      tags={"Ticket request"},
     *      summary="Store new ticket request",
     *      description="Returns ticket request data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TicketRequestCreateRequest")
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
     *                     "name": "A nice ticket request",
     *                     "department_id": 1,
     *                     "process_id": 1,
     *                     "ticket_serial": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                     "request_time": 1655002163,
     *                     "finish_time": 1655002163,
     *                     "priority": 1,
     *                     "comment": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                     "ticket_action": 1,
     *                     "approval_status": 1,
     *                     "created_by": 1234567890,
     *                     "created_at": 1234567890,
     *                     "updated_at": 1234567890,
     *                     "updated_by": 1234567890,
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/TicketRequestPresenter"
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
     * @param  TicketRequestCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TicketRequestCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(TicketRequestValidator::RULE_CREATE);

        $ticketRequest = $this->service->create($request->all());

        return $this->show($ticketRequest['data']['id']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/ticket-request/{ticketId}",
     *     operationId="getDetailTicketRequest",
     *     tags={"Ticket request"},
     *     summary="Get detail of ticket request",
     *     description="Returns detail of ticket request",
     *      @OA\Parameter(
     *         name="ticketId",
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
     *                example={{
     *                  "id": 1,
     *                  "name": "A nice ticket request",
     *                  "deparment_id": 1,
     *                  "process_id": 1,
     *                  "ticket_serial": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                  "request_time": 1655002163,
     *                  "finish_time": 1655002163,
     *                  "priority": 1,
     *                  "comment": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                  "ticket_action": 1,
     *                  "approval_status": 1,
     *                  "created_by": 1234567890,
     *                  "created_at": 1234567890,
     *                  "updated_at": 1234567890,
     *                  "updated_by": 1234567890,
     *                  "delete_at":null,
     *                }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/TicketRequestPresenter"
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
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $ticketRequest = $this->service->show($id);

        return $this->responseSuccess([$ticketRequest['data']]);
    }

    /**
     * @OA\Put(
     *      path="/api/v1/ticket-request/{ticketRequestId}",
     *      operationId="updateTicketRequest",
     *      tags={"Ticket request"},
     *      summary="Update ticket request",
     *      description="Returns ticket request data",
     *      @OA\Parameter(
     *         name="ticketRequestId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TicketRequestUpdateRequest")
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
     *                     "id": 1,
     *                     "name": "A nice ticket request",
     *                     "department_id": 1,
     *                     "process_id": 1,
     *                     "ticket_serial": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                     "request_time": 1655002163,
     *                     "finish_time": 1655002163,
     *                     "priority": 1,
     *                     "comment": "Lorem Ipsum is simply dummy text of the printing and typesetting",
     *                     "ticket_action": 1,
     *                     "approval_status": 1,
     *                     "created_by": 1234567890,
     *                     "created_at": 1234567890,
     *                     "updated_at": 1234567890,
     *                     "updated_by": 1234567890,
     *                  }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/TicketRequestPresenter"
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
     * @param  TicketRequestUpdateRequest $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TicketRequestUpdateRequest $request, int $id): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(TicketRequestValidator::RULE_UPDATE);

        $this->service->update($request->all(), $id);
        return $this->show($id);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/ticket-request/{id}",
     *      operationId="destroyTicketRequest",
     *      tags={"Ticket request"},
     *      summary="Delete ticket request",
     *      description="Returns delete ticket request data",
     *       @OA\Parameter(
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
     *                       "id": 1
     *                          }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/TicketRequestPresenter"
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
     * @OA\Get(
     *     path="/api/v1/process-ticket-request",
     *     operationId="getprocessTicketRequest",
     *     tags={"Ticket request"},
     *     summary="Get list of process ticket request",
     *     description="Returns list of process ticket request",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="created_by",
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
     *          name="nameOrCode",
     *          description="Mã hoặc tên quy trình(Tìm kiếm theo quy trình)",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="version",
     *          description="version quy trình(Tìm kiếm theo quy trình)",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="code",
     *          description="Mã phiếu(Tìm kiếm theo phiếu yêu cầu)",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="request_time_start",
     *          description="Ngày tạo phiếu(Tìm kiếm theo phiếu yêu cầu)",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="request_time_end",
     *          description="Ngày tạo phiếu(Tìm kiếm theo phiếu yêu cầu)",
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
     *          name="approval_status_ticket",
     *          description="Trạng thái phiếu(Tìm kiếm theo phiếu)",
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
     *                example={{
     *                  "id": 1,
     *                  "code": "3921684835",
     *                  "name": "Jaqueline Cronin",
     *                  "short_name": "Maeve",
     *                  "owner_deparment_id": 5,
     *                  "target_apply_type": 2,
     *                  "regulation_document": "Beatae voluptatem fugiat voluptates sint quo aut",
     *                  "regulation_start_date": 1656924570,
     *                  "regulation_end_date": 1656924570,
     *                  "description": "Quod sunt consequuntur distinctio porro at non id sit",
     *                  "approval_status": 3,
     *                  "approval_target_type": 2,
     *                  "deleted_at": null,
     *                  "version": 1,
     *                  "created_by": 9759662381,
     *                  "created_at": 1656924570,
     *                  "process_id": null,
     *                  "updated_at": 1656924570,
     *                  "updated_by": 4476139327,
     *                  "status": 1,
     *                  "required_time": null,
     *                  "request_completion_time": null,
     *                  "out_of_date": 0,
     *                  "activation_date": null,
     *                  "ticket_request": {{
     *                      "id": 2,
     *                      "name": "uC8lYLc7xV",
     *                      "department_id": 1,
     *                      "process_id": 1,
     *                      "ticket_serial": "HWGPNFJRD8wq7wl9RHOAiX81ZKwKsdMaWgtG4PC2",
     *                      "request_time": 1656924571,
     *                      "finish_time": 1656924571,
     *                      "priority": 1,
     *                      "comment": "N1ixZoAeNgBb3VS9vh1tXjssu60C1virj9gAEefo",
     *                      "ticket_action": 1,
     *                      "approval_status": 1,
     *                      "created_by": 9445796946,
     *                      "created_at": 1656924571,
     *                      "updated_at": 1656924571,
     *                      "updated_by": 8060194835,
     *                      "deleted_at": null,
     *                      "complete": 1,
     *                      "ticket_type": 1
     *                  }}
     *                }},
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/TicketRequestPresenter"
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

    public function getProcessTicketRequest(Request $request): JsonResponse
    {
        $ticket = $this->service->getProcessTicketRequests($request->all());
        return $this->responseSuccess($ticket['data']);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/process-ticket-request/{processId}",
     *     operationId="getprocessTicketRequestDefault",
     *     tags={"Ticket request"},
     *     summary="Get list of process ticket default request",
     *     description="Returns list of process ticket default request",
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="processId",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=true,
     *          in="path",
     *          name="created_by",
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
     *          name="nameOrCode",
     *          description="Mã hoặc tên quy trình(Tìm kiếm theo quy trình)",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="version",
     *          description="version quy trình(Tìm kiếm theo quy trình)",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="code",
     *          description="Mã phiếu(Tìm kiếm theo phiếu yêu cầu)",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="request_time_start",
     *          description="Ngày tạo phiếu(Tìm kiếm theo phiếu yêu cầu)",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          required=false,
     *          in="path",
     *          name="request_time_end",
     *          description="Ngày tạo phiếu(Tìm kiếm theo phiếu yêu cầu)",
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
     *          name="approval_status_ticket",
     *          description="Trạng thái phiếu(Tìm kiếm theo phiếu)",
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
     *                  "id": 1,
     *                  "code": "3921684835",
     *                  "name": "Jaqueline Cronin",
     *                  "short_name": "Maeve",
     *                  "owner_deparment_id": 5,
     *                  "target_apply_type": 2,
     *                  "regulation_document": "Beatae voluptatem fugiat voluptates sint quo aut",
     *                  "regulation_start_date": 1656924570,
     *                  "regulation_end_date": 1656924570,
     *                  "description": "Quod sunt consequuntur distinctio porro at non id sit",
     *                  "approval_status": 3,
     *                  "approval_target_type": 2,
     *                  "deleted_at": null,
     *                  "version": 1,
     *                  "created_by": 9759662381,
     *                  "created_at": 1656924570,
     *                  "process_id": null,
     *                  "updated_at": 1656924570,
     *                  "updated_by": 4476139327,
     *                  "status": 1,
     *                  "required_time": null,
     *                  "request_completion_time": null,
     *                  "out_of_date": 0,
     *                  "activation_date": null,
     *                  "ticket_request": {{
     *                      "id": 2,
     *                      "name": "uC8lYLc7xV",
     *                      "department_id": 1,
     *                      "process_id": 1,
     *                      "ticket_serial": "HWGPNFJRD8wq7wl9RHOAiX81ZKwKsdMaWgtG4PC2",
     *                      "request_time": 1656924571,
     *                      "finish_time": 1656924571,
     *                      "priority": 1,
     *                      "comment": "N1ixZoAeNgBb3VS9vh1tXjssu60C1virj9gAEefo",
     *                      "ticket_action": 1,
     *                      "approval_status": 1,
     *                      "created_by": 9445796946,
     *                      "created_at": 1656924571,
     *                      "updated_at": 1656924571,
     *                      "updated_by": 8060194835,
     *                      "deleted_at": null,
     *                      "complete": 1,
     *                      "ticket_type": 1
     *                  }}
     *                },
     *                  @OA\Items(
     *                      type="object",
     *                      ref="#/components/schemas/TicketRequestPresenter"
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
     * @param int $processId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProcessTicketRequestDefault(int $processId, Request $request): JsonResponse
    {
        $ticket = $this->service->getProcessTicketRequestDefault($processId, $request->all());
        return $this->responseSuccess($ticket);
    }
}
