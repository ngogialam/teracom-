<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Step Group Conditioncreate request",
 *      description="Step Group Condition create request body data",
 *      type="object",
 *      required={}
 * )
 *
 * @SuppressWarnings(PHPMD)
 */

class StepGroupConditionCreateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="group_first_step",
     *      description="Group First Step of the step group condition",
     *      example=1
     * )
     *
     * @var int
     */

    public $group_first_step;

    /**
     * @OA\Property(
     *      title="step_condition",
     *      description="Step Condition of the step group condition",
     *      example=1
     * )
     *
     * @var int
     */

    public $step_condition;

    /**
     * @OA\Property(
     *      title="step_order",
     *      description="Step Order of the step group condition",
     *      example=1,
     *      enum={"1: AND", "2: OR"}
     * )
     *
     * @var int
     */

    public $step_order;
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
            'group_first_step' => 'sometimes',
            'step_condition' => 'sometimes',
            'step_order' => 'sometimes'
        ];
    }
}
