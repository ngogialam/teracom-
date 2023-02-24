<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests\FileAttachmentCreateRequest;
use App\Validators\FileAttachmentValidator;
use App\Http\Controllers\BaseController;
use App\Services\FileAttachmentService;
use Illuminate\Http\JsonResponse;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class FileAttachmentsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class FileAttachmentsController extends BaseController
{
    /**
     * FileAttachmentsController constructor.
     *
     * @param FileAttachmentService $service
     * @param FileAttachmentValidator $validator
     */
    public function __construct(
        protected FileAttachmentValidator $validator,
        protected FileAttachmentService $service
    ) {
    }

    /**
     * @OA\Get(
     *      path="/api/v1/file-attachment",
     *      operationId="showFileAttachment",
     *      tags={"File Attachment"},
     *      summary="List file attachment",
     *      description="Returns file attachment data",
     *      @OA\Parameter(
     *         name="target_id",
     *         in="path",
     *         description="file that to be list",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\Parameter(
     *         name="target_type",
     *         in="path",
     *         description="file that to be list",
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
     *                 example={{
     *                  "id": 1,
     *                  "file_name": "Screen Shot 2022-06-12 at 23.18.53.png",
     *                  "file_uid": "1",
     *                  "target_id": "1",
     *                  "target_type": "1",
     *                  "created_by": "124324",
     *                  "created_at": "124324",
     *                  "updated_at": "124324",
     *                  "updated_by": "124324",
     *                  "deleted_at": null
     *                },
     * {
     *                  "id": 2,
     *                  "file_name": "Capture.png",
     *                  "file_uid": "1",
     *                  "target_id": "1",
     *                  "target_type": "1",
     *                  "created_by": "12454324",
     *                  "created_at": "12445324",
     *                  "updated_at": "124456324",
     *                  "updated_by": "1255324",
     *                  "deleted_at": null
     *                },
     *              },
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
     * @param Request $request
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        $fileAttachments = $this->service->all($request->all());
        return $this->responseSuccess($fileAttachments['data']);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/file-attachment",
     *      operationId="storeFileAttachment",
     *      tags={"File Attachment"},
     *      summary="Store first file attachment",
     *      description="Returns file attachment data",
     *      @OA\RequestBody(
     *      @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(
     *                         @OA\Property(
     *                             description="file",
     *                             property="file",
     *                             type="string", format="binary"
     *                         ),
     *                          @OA\Property(
     *                             property="file_uid",
     *                             description="File  File of file attachments",
     *                              example=1
     *                          ),
     *                           @OA\Property(
     *                             property="target_id",
     *                             description="Target  id of file attachments",
     *                              example=1
     *                          ),
     *                          @OA\Property(
     *                             property="target_type",
     *                             description="Target  type of file attachments",
     *                              example=1
     *                          ),
     *                     )
     *                 }
     *             )
     *         )
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
     *                 "file_name": "Screen Shot 2022-06-12 at 23.18.53.png",
     *                 "file_uid": "1",
     *                 "target_id": "1",
     *                 "target_type": "1",
     *                  "created_by": "124324",
     *                  "created_at": "124324",
     *                  "updated_at": "124324",
     *                  "updated_by": "124324",
     *                  "deleted_at": null
     *                }, {
     *                   "id": 2,
     *                   "file_name": "Screen Shot 2022-06-12 at 23.18.53.png",
     *                   "file_uid": "1",
     *                   "target_id": "1",
     *                   "target_type": "1",
     *                   "created_by": "124324",
     *                   "created_at": "124324",
     *                   "updated_at": "124324",
     *                   "updated_by": "124324",
     *                   "deleted_at": null
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
     * @param  FileAttachmentCreateRequest $request
     * @return JsonResponse
     * @throws ValidatorException
     */
    public function store(FileAttachmentCreateRequest $request): JsonResponse
    {
        $this->validator->with($request->all())->passesOrFail(FileAttachmentValidator::RULE_CREATE);
        $fileAttachment = $this->service->create($request->all());

        return $this->responseSuccess([$fileAttachment['data']]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/file-attachment/{id}",
     *     operationId="getFileAttachment",
     *     tags={"File Attachment"},
     *     summary="Show list file attachment",
     *     description="Returns list of my file attachment",
     *      @OA\Parameter(
     *          required=true,
     *          in="query",
     *          name="id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
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
     *                   "file_name": "Capture.png",
     *                   "file_uid": "1",
     *                   "target_id": "1",
     *                   "target_type": "1",
     *                   "created_by": "155355",
     *                   "created_at": "155355",
     *                   "updated_at": "155324",
     *                   "updated_by": "125524",
     *                   "deleted_at": null
     *                },
     *              },
     *                  @OA\Items(
     *                      type="object",
     *                  )
     *              ),
     *          ),
     *       ),
     *     @OA\Response(
     *        response=400,
     *        description="Bad Request"
     *      ),
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
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $fileAttachment = $this->service->show($id);

        return $this->responseSuccess($fileAttachment['data']);
    }
}
