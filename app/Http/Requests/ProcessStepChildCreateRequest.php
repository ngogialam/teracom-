<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Process step child create request",
 *      description="Process step child create request body data",
 *      type="object",
 *      required={"process_id","child_process_id"}
 * )
 *
 * @SuppressWarnings(PHPMD)
 */
class ProcessStepChildCreateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="process_id",
     *      description="Process Id of the new process step",
     *      example=1
     * )
     *
     * @var string
     */

    public $process_id;

    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new process step",
     *      example="New process step"
     * )
     *
     * @var string
     */

    public $name;

    /**
     * @OA\Property(
     *      title="action_type",
     *      description="Action Type of the new process step",
     *      example=1,
     *      enum={"0: kết thúc","1: đề xuất", "2: chuyển tiếp", "3: phê duyệt"}
     * )
     *
     * @var string
     */

    public $action_type;

    /**
     * @OA\Property(
     *      title="step_type",
     *      description="Step Type of the new process step. You can enter option: 3: bước  là 1 quy trình khác",
     *      example=3,
     *      enum={"3: bước  là 1 quy trình khác"}
     * )
     *
     * @var string
     */

    public $step_type;
    /**
     * @OA\Property(
     *      title="step_order",
     *      description="Step Order of the new process step",
     *      example=1
     * )
     *
     * @var string
     */

    public $step_order;

    /**
     * @OA\Property(
     *      title="child_process_id",
     *      description="Step Process ID of the new process step",
     *      example=1
     * )
     *
     * @var string
     */

    public $child_process_id;

    /**
     * @OA\Property(
     *      title="sla_quantity",
     *      description="Sla quantity of the new process step",
     *      example=1
     * )
     *
     * @var string
     */

    public $sla_quantity;

    /**
     * @OA\Property(
     *      title="sla_unit",
     *      description="Sla Unit of the new process step",
     *      example=1,
     *      enum={"1: giờ", "2: ngày", "3: ngày làm việc"}
     * )
     *
     * @var string
     */

    public $sla_unit;
    /**
     * @OA\Property(
     *      title="transfer_condition_type",
     *      description="Transfer Condition Type of the new process step",
     *      example=1,
     *      enum={"1: tất cả đều đúng", "2: 1 trong các đk đúng"}
     * )
     *
     * @var string
     */

    public $transfer_condition_type;
    /**
     * @OA\Property(
     *      title="created_by",
     *      description="Created by of the new process step",
     *      example=1
     * )
     *
     * @var string
     */

    public $created_by;
    /**
     * @OA\Property(
     *      title="created_at",
     *      description="Created At of the new process step",
     *      example=1234567890
     * )
     *
     * @var string
     */

    public $created_at;

    /**
     * @OA\Property(
     *      title="updated_at",
     *      description="Updated At of the new process step",
     *      example=1234567890
     * )
     *
     * @var string
     */


    public $updated_at;
    /**
     * @OA\Property(
     *      title="updated_by",
     *      description="Updated At of the new process step",
     *      example=1872600
     * )
     *
     * @var string
     */

    public $updated_by;
    /**
     * @OA\Property(
     *      title="status",
     *      description="Status of the new process step",
     *      example=1,
     *      enum={"0 : đang thực hiện", "1: hoàn thành", "2: không duyệt"}
     * )
     *
     * @var string
     */

    public $status;
    /**
     * @OA\Property(
     *      title="timesheet",
     *      description="Time sheet of the new process step",
     *      example=1
     * )
     *
     * @var int
     */

    public $timesheet;

    /**
     *   @OA\Property(
     *       property="step_transfer_conditions",
     *       type="array",
     *       @OA\Items(
     *           @OA\Property(property="step_condition", type="int", example=1,enum={"1: AND", "2: OR"}),
     *           @OA\Property(property="step_order", type="int", example=1),
     *           @OA\Property(property="next_step_type", type="int",example=1,enum={"1: bước đơn lẻ", "2: nhóm bước"}),
     *           @OA\Property(property="group_condition_id", type="int", example=1),
     *          ),
     *       )
     *    )
     */
    public $step_transfer_conditions;

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
            'process_id' => 'required',
            'name' => 'sometimes|max:250',
            'action_type' => 'sometimes',
            'step_type' => 'sometimes',
            'step_order' => 'sometimes',
            'child_process_id' => 'required',
            'sla_quantity' => 'sometimes',
            'sla_unit' => 'sometimes',
            'transfer_condition_type' => 'sometimes',
            'created_by' => 'sometimes',
            'created_at' => 'sometimes',
            'updated_at' => 'sometimes',
            'updated_by' => 'sometimes',
            'status' => 'sometimes',
            'timesheet' => 'sometimes',
            'step_transfer_conditions.*.step_condition' => 'sometimes',
            'step_transfer_conditions.*.step_order' => 'sometimes',
            'step_transfer_conditions.*.next_step_type' => 'sometimes',
            'step_transfer_conditions.*.group_condition_id' => 'sometimes',
        ];
    }
}
