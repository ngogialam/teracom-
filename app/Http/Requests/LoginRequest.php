<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Login request",
 *      description="login request body data",
 *      type="object",
 *      required={"payload","expired_in"}
 * )
 *
 * @SuppressWarnings(PHPMD)
 */
class LoginRequest extends FormRequest
{
    /**
     *   @OA\Property(
     *       property="payload",
     *       type="array",
     *       @OA\Items(
     *           @OA\Property(property="id", type="int", example=868),
     *           @OA\Property(property="code", type="string", example="G00001"),
     *           @OA\Property(property="email", type="string",example="mor.test01@ggg.com.vn"),
     *           @OA\Property(property="user_name", type="string", example="mor.test01"),
     *           @OA\Property(property="full_name", type="string", example="mor.test01"),
     *           @OA\Property(property="status", type="int", example=1),
     *           @OA\Property(property="department", type="array",
     *             @OA\Items(
     *                  @OA\Property(property="id", type="int", example=1),
     *                  @OA\Property(property="name", type="string", example="test"),
     *              )
     *          ),
     *           @OA\Property(property="devision", type="array",
     *             @OA\Items(
     *                  @OA\Property(property="id", type="int", example=1),
     *                  @OA\Property(property="name", type="string", example="test"),
     *              )
     *          ),
     *           @OA\Property(property="roles", type="array",
     *             @OA\Items(
     *                  @OA\Property(property="id", type="int", example=1),
     *                  @OA\Property(property="name", type="string", example="test"),
     *              )
     *          ),
     *           @OA\Property(property="groups", type="array",
     *             @OA\Items(
     *                  @OA\Property(property="id", type="int", example=1),
     *                  @OA\Property(property="name", type="string", example="test"),
     *              )
     *          ),
     *           @OA\Property(property="subordinates", type="int", example=1655812861),
     *           @OA\Property(property="permissions", type="array",
     *             @OA\Items(
     *                  @OA\Property(property="id", type="int", example=1),
     *                  @OA\Property(property="name", type="string", example="test"),
     *              )
     *          ),
     *           @OA\Property(property="managements", type="array",
     *             @OA\Items(
     *                  @OA\Property(property="id", type="int", example=1),
     *                  @OA\Property(property="name", type="string", example="test"),
     *              )
     *          ),
     *          )
     *       )
     *    )
     *    )
     */

    public $payload;

    /**
     * @OA\Property(
     *      title="expired_in",
     *      example="3600"
     * )
     *
     * @var integer
     */

    public $expired_in;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "payload"         => "required",
            "expired_in"      => "required|int",
        ];
    }
}
