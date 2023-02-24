<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Process create request",
 *      description="Process create request body data",
 *      type="object",
 *      required={"code","name","short_name","owner_deparment_id","target_apply_type","created_at","created_by"}
 * )
 *
 * @SuppressWarnings(PHPMD)
 */
class ProcessCreateRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="code",
     *      description="Process code",
     *      example="20GA0001"
     * )
     *
     * @var string
     */

    public $code;
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new process",
     *      example="A nice process"
     * )
     *
     * @var string
     */

    public $name;

    /**
     * @OA\Property(
     *      title="short_name",
     *      description="Short name of the new process",
     *      example="DXMB"
     * )
     *
     * @var string
     */

    public $short_name;

    /**
     * @OA\Property(
     *      title="owner_deparment_id",
     *      description="Owner deparment id of the new process",
     *      example=1
     * )
     *
     * @var integer
     */

    public $owner_deparment_id;

    /**
     * @OA\Property(
     *      title="target_apply_type",
     *      description="Target apply type of the new process",
     *      example=1,
     *      enum={"1: toàn hệ thống", "2: nội bộ"}
     * )
     *
     * @var integer
     */

    public $target_apply_type;

    /**
     * @OA\Property(
     *      title="regulation_document",
     *      description="Regulation document of the new process",
     *      example="Good guide"
     * )
     *
     * @var string
     */

    public $regulation_document;


    /**
     * @OA\Property(
     *      title="regulation_start_date",
     *      description="Regulation start date of the new process",
     *      example=1234567890
     * )
     *
     * @var integer
     */

    public $regulation_start_date;

    /**
     * @OA\Property(
     *      title="regulation_end_date",
     *      description="Regulation end date of the new process",
     *      example=1234567890,
     * )
     *
     * @var integer
     */

    public $regulation_end_date;

    /**
     * @OA\Property(
     *      title="description",
     *      description="Descriptionof the new process",
     *      example="This is good process",
     * )
     *
     * @var string
     */

    public $description;

    /**
     * @OA\Property(
     *      title="approval_status",
     *      description="Approval status of the new process",
     *      example=1,
     *      enum={"1: bản nháp", "2: chờ phê duyệt/gửi đi", "3: phê duyệt", "4: từ chối", "5: hết hiệu lực"}
     * )
     *
     * @var integer
     */

    public $approval_status;

    /**
     * @OA\Property(
     *      title="approval_target_type ",
     *      description="Approval target type  of the new process",
     *      example=1,
     *      enum={"1: một người", "2: một nhóm"}
     * )
     *
     * @var integer
     */

    public $approval_target_type;

    /**
     * @OA\Property(
     *      title="version",
     *      description="Version of the new process",
     *      example=1,
     * )
     *
     * @var double
     */

    public $version;

    /**
     * @OA\Property(
     *      title="process_id",
     *      description="Id of old version of the process",
     *      example=1
     * )
     *
     * @var integer
     */

    public $process_id;

    /**
     * @OA\Property(
     *      title="created_by",
     *      description="Created by of the new process",
     *      example=2570871942
     * )
     *
     * @var integer
     */

    public $created_by;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="created at of the new process",
     *      example=1234567890
     * )
     *
     * @var integer
     */

    public $created_at;

    /**
     * @OA\Property(
     *      title="updated_at",
     *      description="Updated at of the new process",
     *      example=1234567890
     * )
     *
     * @var integer
     */

    public $updated_at;

    /**
     * @OA\Property(
     *      title="updated_by",
     *      description="Updated by of the new process",
     *      example=2570871942,
     * )
     *
     * @var integer
     */

    public $updated_by;

    /**
     * @OA\Property(
     *      title="status",
     *      description="Status of the new process",
     *      example=1,
     * )
     *
     * @var integer
     */

    public $status;

    /**
     * @OA\Property(
     *      title="file_attachment_ids",
     *      description="File attachment id  of the new process",
     *      example=1,
     * )
     *
     * @var integer
     */

    public $file_attachment_ids;


    /**
     *   @OA\Property(
     *       property="process_steps",
     *       type="array",
     *       @OA\Items(
     *           @OA\Property(property="name", type="string", example="process step 1"),
     *           @OA\Property(property="action_type", type="int", example=1, enum={"0: kết thúc","1:đề xuất", "2 chuyển tiếp", "3: phê duyệt"}),
     *           @OA\Property(property="step_type", type="int",example=1,enum={"0: bước kết thúc", "1: bước bắt đầu", "2: bước quy trình", "3: bước  là 1 quy trình khác"}),
     *           @OA\Property(property="step_order", type="int", example=1),
     *           @OA\Property(property="child_process_id", type="int", example=1),
     *           @OA\Property(property="sla_quantity", type="int", example=1),
     *           @OA\Property(property="sla_unit", type="int", example=1,enum={"1: giờ", "2: ngày", "3: ngày làm việc"}),
     *           @OA\Property(property="transfer_condition_type", type="int", example=1,enum={"1: tất cả đều đúng", "2: 1 trong các đk đúng"}),
     *           @OA\Property(property="created_by", type="int", example=1),
     *           @OA\Property(property="created_at", type="int", example=1655812861),
     *           @OA\Property(property="updated_at", type="int", example=1655812861),
     *           @OA\Property(property="updated_by", type="int", example=1),
     *           @OA\Property(property="status", type="int", example=1,enum={"0 : đang thực hiện", "1: hoàn thành", "2: không duyệt"}),
     *           @OA\Property(property="timesheet", type="int", example=1),
     *          )
     *       )
     *    )
     *    )
     */
    public $process_steps;

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
            'code' => 'required|min:6,max:49',
            'name' => 'required|max:250',
            'short_name' => 'required|max:50',
            'owner_deparment_id' => 'required',
            'target_apply_type' => 'required|in:1,2',
            'regulation_document' => 'sometimes|max:250',
            'regulation_start_date' => 'sometimes',
            'regulation_end_date' => 'sometimes',
            'description' => 'sometimes',
            'approval_status' => 'sometimes',
            'approval_target_type' => 'sometimes|in:1,2',
            'version' => 'sometimes',
            'process_id' => 'sometimes',
            'created_at' => 'required',
            'updated_at' => 'sometimes',
            'created_by' => 'required|integer|min:1',
            'updated_by' => 'sometimes',
            'status' => 'sometimes|in:0,1',
            'process_steps.*.name' => 'sometimes|max:250',
            'process_steps.*.action_type' => 'required_with:name|in:0,1,2,3',
            'process_steps.*.step_type' => 'required_with:name|in:0,1,2,3',
            'process_steps.*.step_order' => 'required',
            'process_steps.*.child_process_id' => 'sometimes',
            'process_steps.*.sla_quantity' => 'sometimes',
            'process_steps.*.sla_unit' => 'sometimes|in:1,2,3',
            'process_steps.*.transfer_condition_type' => 'sometimes|in:1,2',
            'process_steps.*.created_by' => 'sometimes',
            'process_steps.*.created_at' => 'sometimes',
            'process_steps.*.updated_at' => 'sometimes',
            'process_steps.*.updated_by' => 'sometimes',
            'process_steps.*.status' => 'sometimes|in:0,1,2',
            'timesheet' => 'sometimes|in:0,1',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'in' => 'The :attribute must be one of the following types: :values',
        ];
    }
}
