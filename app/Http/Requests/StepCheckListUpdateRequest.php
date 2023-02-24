<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Step check list create request",
 *      description="Step check list create request body data",
 *      required={"step_id","content","created_at"},
 *      type="array",
 *      required={"step_id","content","created_at"},
 *         example={
 *              {
 *                  "step_id": 1,
 *                  "content": "abc",
 *                  "created_at": "1234567890",
 *                }, {
 *                  "step_id": 1,
 *                  "content": "abc",
 *                  "created_at": "1234567890",
 *                }
 *          },
 *      @OA\Items()
 * )
 *
 * @SuppressWarnings(PHPMD)
 */
class StepCheckListUpdateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="step_id",
     *      description="step_id of the new step",
     *      example="1"
     * )
     *
     * @var integer
     */

    public $step_id;

    /**
     * @OA\Property(
     *      title="content",
     *      description="content of the new step",
     *      example="the content of the article"
     * )
     *
     * @var string
     */

    public $content;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="created_at of the new step",
     *      example="1234567890"
     * )
     *
     * @var integer
     */

    public $created_at;

    /**
     * @OA\Property(
     *      title="deleted_at",
     *      description="deleted_at of the new step",
     *      example="1444555511152"
     * )
     *
     * @var integer
     */

    public $deleted_at;
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
            'step_id' => 'sometimes',
            'content' => 'sometimes',
            'created_at' => 'sometimes'
        ];
    }
}
