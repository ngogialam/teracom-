<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Ticket request create request",
 *      description="Ticket request create request body data",
 *      type="object",
 *      required={"name","department_id","process_id"},
 * )
 * @SuppressWarnings(PHPMD)
 */


class TicketRequestCreateRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="name",
     *      description="Ticket request name",
     *      example="A nice ticket request"
     * )
     *
     * @var string
     */

    public $name;

    /**
     * @OA\Property(
     *      title="department_id",
     *      description="Department id of new ticket request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $department_id;

    /**
     * @OA\Property(
     *      title="process_id",
     *      description="Process id of new ticket request",
     *      example=1
     * )
     *
     * @var integer
     */

    public $process_id;

    /**
     * @OA\Property(
     *      title="ticket_serial",
     *      description="Ticket serial of new ticket request",
     *      example="Lorem Ipsum is simply dummy text of the printing and typesetting"
     * )
     *
     * @var string
     */

    public $ticket_serial;

    /**
     * @OA\Property(
     *      title="request_time",
     *      description="Request time of new ticket request",
     *      example=1655002163
     * )
     *
     * @var integer
     */

    public $request_time;

    /**
     * @OA\Property(
     *      title="finish_time",
     *      description="Finish time of new ticket request",
     *      example=1655002163
     * )
     *
     * @var integer
     */

    public $finish_time;

    /**
     * @OA\Property(
     *      title="priority",
     *      description="Priority of new ticket request",
     *      example=1,
     *      enum={"1: thấp", "2: trung bình", "3: cao"}
     * )
     *
     * @var integer
     */

    public $priority;

    /**
     * @OA\Property(
     *      title="comment",
     *      description="Ticket comment of new ticket request",
     *      example="Lorem Ipsum is simply dummy text of the printing and typesetting"
     * )
     *
     * @var string
     */

    public $comment;

    /**
     * @OA\Property(
     *      title="ticket_action",
     *      description="Ticket action of new ticket request",
     *      example=1,
     *      enum={"1: không làm gì", "2: chuyển tiếp cho người bắt đầu quy trình"}
     * )
     *
     * @var integer
     */

    public $ticket_action;

    /**
     * @OA\Property(
     *      title="approval_status",
     *      description="Approval status of new ticket request",
     *      example=1,
     *      enum={"0: bản nháp", "2: chờ phê duyệt/gửi đi", "2: phê duyệt", "3: từ chối"}
     * )
     *
     * @var integer
     */

    public $approval_status;

    /**
     * @OA\Property(
     *      title="created_by",
     *      description="Created by of the new ticket request",
     *      example=1234567890
     * )
     *
     * @var integer
     */

    public $created_by;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="Created at of the new ticket request",
     *      example=1234567890
     * )
     *
     * @var integer
     */

    public $created_at;

    /**
     * @OA\Property(
     *      title="updated_at",
     *      description="Updated at of the new ticket request",
     *      example=1234567890
     * )
     *
     * @var integer
     */

    public $updated_at;

    /**
     * @OA\Property(
     *      title="updated_by",
     *      description="Updated by of the new ticket request",
     *      example=1234567890
     * )
     *
     * @var integer
     */

    public $updated_by;

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
            'name' => 'required|max:250',
            'department_id' => 'required',
            'process_id' => 'required|exists:process,id',
            'ticket_serial' => 'sometimes|max:250',
            'request_time' => 'sometimes',
            'finish_time' => 'sometimes',
            'priority' => 'required|in:1,2,3',
            'comment' => 'sometimes|max:4000',
            'ticket_action' => 'sometimes|in:1,2',
            'approval_status' => 'sometimes|in:0,1,2,3',
            'created_at' => 'sometimes',
            'updated_at' => 'sometimes',
            'created_by' => 'sometimes|integer|min:1',
            'updated_by' => 'sometimes|integer|min:1',
        ];
    }
}
