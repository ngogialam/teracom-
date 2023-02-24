<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    public function __construct(
        protected AuthService $service
    ) {
    }

    /**
     * @OA\Post (
     *     path="/api/v1/login",
     *     tags={"Auth"},
     *     summary="Đăng nhập",
     *     description="Trả về token và thời gian hết hạn",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginRequest")
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
     *                  type="object",
     *                  ref="#/components/schemas/LoginResponse"
     *              ),
     *          ),
     *       ),
     * )
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->service->generateAccessToken($request);
        return $this->responseSuccess([
            'access_token' => (String)$token,
            'type' => 'Bearer',
            'expired_in' => $request['expired_in'],
        ]);
    }

    /**
     * @OA\Get (
     *     path="/api/v1/profile",
     *     tags={"Auth"},
     *     summary="Lấy thông tin user",
     *     description="Thông tin user hiện tại",
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
     *                  type="object",
     *                  ref="#/components/schemas/ProfileResponse"
     *              ),
     *          ),
     *       ),
     * )
     *
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        return $this->responseSuccess(auth()->user()->toArray());
    }
}
