<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Step transfer create request",
 *      description="Step transger create request body data",
 *      type="object",
 *      required={}
 * )
 *
 * @SuppressWarnings(PHPMD)
 */

class StepTransferConditionCreateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="step_id",
     *      description="Step Id of the step transfer condition",
     *      example=1
     * )
     *
     * @var int
     */

    public $step_id;

    /**
     * @OA\Property(
     *      title="step_condition",
     *      description="Step condition of the step transfer condition",
     *      example=1
     * )
     *
     * @var int
     */

    public $step_condition;

    /**
     * @OA\Property(
     *      title="step_order",
     *      description="Step Order of the step transfer condition",
     *      example=1,
     *      enum={"1: AND", "2: OR"}
     * )
     *
     * @var int
     */

    public $step_order;

    /**
     * @OA\Property(
     *      title="next_step_type",
     *      description="Next Step Type of the step transfer condition",
     *      example=1
     * )
     *
     * @var int
     */

    public $next_step_type;

    /**
     * @OA\Property(
     *      title="group_condition_id",
     *      description="Group Condition id of the step transfer condition",
     *      example=1
     * )
     *
     * @var int
     */

    public $group_condition_id;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="Created At of the step transfer condition",
     *      example=1872600
     * )
     *
     * @var int
     */

    public $created_at;

    /**
     * @OA\Property(
     *      title="deleted_at",
     *      description="Delete At of the step transfer condition",
     *      example=1872600
     * )
     *
     * @var int
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
            'step_condition' => 'sometimes',
            'step_order' => 'sometimes',
            'next_step_type' => 'sometimes',
            'group_condition_id' => 'sometimes',
            'created_at' => 'sometimes',
        ];
    }
}
