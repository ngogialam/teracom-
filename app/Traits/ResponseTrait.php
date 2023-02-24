<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Trait ResponseTrait.
 *
 * @package App\Contracts
 */
trait ResponseTrait
{
    /**
     * Response success structure.
     *
     * @param $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function responseSuccess(array $data, int $code = Response::HTTP_OK, string  $message = "SUCCESS"): JsonResponse
    {
        return response()->json(
            [
                'code'    => $code,
                'message' => $message,
                'data'    => $data,
            ],
        );
    }

    /**
     * Response error structure.
     *
     * @param $data
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    protected function responseError(array $data, int $code = Response::HTTP_BAD_REQUEST, string $message = "ERROR"): JsonResponse
    {
        return response()->json(
            [
                'code'    => $code,
                'message' => $message,
                'data'    => $data,
            ],
        );
    }
}
