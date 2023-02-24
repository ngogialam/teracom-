<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Step object create request",
 *      description="Step object create request body data",
 *      type="array",
 *      required={"step_id","object_action_type"},
 *         example={
 *              {
 *                  "step_id": 1,
 *                  "object_action_type": "1",
 *                  "object_type": "1",
 *                  "object_id": "1",
 *                  "object_name": "1",
 *                  "object_position": "1",
 *                  "created_at": 1234567890,
 *                  "status": "1",
 *                  "process_id": 1,
 *                  "active":0,
 *                }, {
 *                  "step_id": 1,
 *                  "object_action_type": "1",
 *                  "object_type": "1",
 *                  "object_id": "1",
 *                  "object_name": "1",
 *                  "object_position": "1",
 *                  "created_at": 1234567890,
 *                  "status": "1",
 *                  "process_id": 1,
 *                  "active":0,
 *                }
 *          },
 *      @OA\Items()
 * )
 * @SuppressWarnings(PHPMD)
 */

class StepObjectCreateRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="step_id",
     *      description="Step_id of step object",
     *      example=1
     * )
     *
     * @var int
     */

    public $step_id;

    /**
     * @OA\Property(
     *      title="object_action_type",
     *      description="Object action type of step object",
     *      example=2
     * )
     *
     * @var int
     */

    public $object_action_type;

    /**
     * @OA\Property(
     *      title="object_type",
     *      description="Object type of step object",
     *      example=1,
     *      enum={"0:đơn vị sở hữu quy trình", "1: người thực hiện step", "2:người nhận thông tin step"," 3 : người phê duyệt"}
     * )
     *
     * @var int
     */

    public $object_type;

    /**
     * @OA\Property(
     *      title="object_id",
     *      description="Object id type of step object",
     *      example=1,
     * enum={"1: Theo chức danh ", "2: Theo nhóm người dùng", "3: Theo phòng ban","4: Theo phòng ban & chức danh", "5: Theo người dùng"}
     * )
     *
     * @var int
     */

    public $object_id;

    /**
     * @OA\Property(
     *      title="object_name",
     *      description="Object name type of step object",
     *      example="name deparment"
     * )
     *
     * @var string
     */

    public $object_name;

    /**
     * @OA\Property(
     *      title="object_position",
     *      description="Object position type of step object",
     *      example="user"
     * )
     *
     * @var string
     */

    public $object_position;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="created at type of step object",
     *      example=1872600
     * )
     *
     * @var int
     */

    public $created_at;

    /**
     * @OA\Property(
     *      title="status",
     *      description="Status type of step object",
     *      example=1
     * )
     *
     * @var int
     */

    public $status;

    /**
     * @OA\Property(
     *      title="active",
     *      description="active type of step object",
     *      example=1,
     *      enum={"0: no active", "1: active"}
     * )
     *
     * @var int
     */

    public $active;

    /**
     * @OA\Property(
     *      title="process_id",
     *      description="Process id type of step object",
     *      example=1
     * )
     *
     * @var int
     */

    public $process_id;

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
            '*.step_id' => 'sometimes|max:50',
            '*.object_action_type' => 'required|in:1,2,3',
            '*.object_type' => 'sometimes',
            '*.object_id' => 'sometimes',
            '*.object_name' => 'sometimes',
            '*.object_position' => 'sometimes',
            '*.created_at' => 'sometimes',
            '*.status' => 'sometimes',
            '*.process_id' => 'sometimes',
            '*.active' => 'sometimes'
        ];
    }
}
