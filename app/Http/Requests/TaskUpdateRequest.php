<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Task update request",
 *      description="Task update request request body data",
 *      type="object",
 *      required={"ticket_req_id","step_id","task_type","assignee_id","department_id","actual_time","action","approval_status","rollback_step_id","rollback_type","comment","status"},
 * )
 * @SuppressWarnings(PHPMD)
 */

class TaskUpdateRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="ticket_req_id",
     *      description="ticket req id request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $ticket_req_id;

    /**
     * @OA\Property(
     *      title="step_id",
     *      description="step id request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $step_id;

    /**
     * @OA\Property(
     *      title="task_type",
     *      description="task type request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $task_type;

    /**
     * @OA\Property(
     *      title="assignee_id",
     *      description="assignee id request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $assignee_id;

    /**
     * @OA\Property(
     *      title="department_id",
     *      description="departmentd id request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $department_id;

    /**
     * @OA\Property(
     *      title="actual_complete_time",
     *      description="actual completed time request",
     *      example=1654609032
     * )
     *
     * @var integer
     */

    public $actual_complete_time;

    /**
     * @OA\Property(
     *      title="expected_complete_time",
     *      description="expected time completed request",
     *      example=1654609032
     * )
     *
     * @var integer
     */

    public $expected_complete_time;

    /**
     * @OA\Property(
     *      title="action",
     *      description="action request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $action;

    /**
     * @OA\Property(
     *      title="approval_status",
     *      description="approval status request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $approval_status;

    /**
     * @OA\Property(
     *      title="rollback_step_id",
     *      description="rollback step id  request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $rollback_step_id;

    /**
     * @OA\Property(
     *      title="rollback_type",
     *      description="rollback type request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $rollback_type;

    /**
     * @OA\Property(
     *      title="comment",
     *      description="comment request",
     *      example="Lorem Ipsum is simply dummy text of the printing and typesetting"
     * )
     *
     * @var string
     */

    public $comment;

    /**
     * @OA\Property(
     *      title="status",
     *      description="status request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $status;

    /**
     * @OA\Property(
     *      title="file_attachment_ids",
     *      description="File attachment id  of the task",
     *      example=1,
     * )
     *
     * @var integer
     */

    public $file_attachment_ids;

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
            'ticket_req_id' => 'sometimes',
            'step_id' => 'sometimes',
            'task_type' => 'sometimes',
            'assignee_id' => 'sometimes',
            'department_id' => 'sometimes',
            'actual_completed_time' => 'sometimes|max:50',
            'actual_time' => 'sometimes',
            'action' => 'sometimes',
            'approval_status' => 'sometimes',
            'rollback_step_id' => 'sometimes',
            'rollback_type' => 'sometimes|in:1,2',
            'comment' => 'sometimes|max:4000',
            'status' => 'sometimes',
        ];
    }
}
