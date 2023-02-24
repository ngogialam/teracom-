<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Task timesheet create request",
 *      description="Task timesheet create request body data",
 *      required={"created_at"},
 *      type="array",
 *         example={
 *              {
 *                  "work_time": 1656338245,
 *                  "number_working": 1656338245,
 *                  "number_actual_time": 1656338245,
 *                  "note": "Lorem Ipsum is simply dummy text of the printing and typesetting",
 *                  "created_at": 1656338245,
 *                  "updated_at": 1656338245,
 *                  "created_by": 1656338245,
 *                  "updated_by": 1656338245,
 *                  "process_id": 1,
 *                }, {
 *                  "work_time": 1656338245,
 *                  "number_working": 1656338245,
 *                  "number_actual_time": 1656338245,
 *                  "note": "Lorem Ipsum is simply dummy text of the printing and typesetting",
 *                  "created_at": 1656338245,
 *                  "updated_at": 1656338245,
 *                  "created_by": 1656338245,
 *                  "updated_by": 1656338245,
 *                  "process_id": 2,
 *                }
 *          },
 *      @OA\Items()
 * )
 * @SuppressWarnings(PHPMD)
 */

class TaskTimesheetCreateRequest extends FormRequest
{

    /**
     * @OA\Property(
     *      title="work_time",
     *      description="work time of task timesheet",
     *      example=1656338245
     * )
     *
     * @var integer
     */

    public $work_time;

    /**
     * @OA\Property(
     *      title="number_working",
     *      description="number working of task timesheet",
     *      example=1656338245
     * )
     *
     * @var integer
     */

    public $number_working;

    /**
     * @OA\Property(
     *      title="number_actual_time",
     *      description="number actual time of task timesheet",
     *      example=1656338245
     * )
     *
     * @var integer
     */

    public $number_actual_time;

    /**
     * @OA\Property(
     *      title="note",
     *      description="note of task timesheet",
     *      example="Lorem Ipsum is simply dummy text of the printing and typesetting"
     * )
     *
     * @var string
     */

    public $note;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="created at of task timesheet",
     *      example=1656338245
     * )
     *
     * @var int
     */

    public $created_at;

    /**
     * @OA\Property(
     *      title="updated_at",
     *      description="updated at of task timesheet",
     *      example=1656338245
     * )
     *
     * @var int
     */

    public $updated_at;

    /**
     * @OA\Property(
     *      title="created_by",
     *      description="created by of task timesheet",
     *      example=1656338245
     * )
     *
     * @var integer
     */

    public $created_by;

    /**
     * @OA\Property(
     *      title="updated_by",
     *      description="updated by of task timesheet",
     *      example=1656338245
     * )
     *
     * @var integer
     */

    public $updated_by;

    /**
     * @OA\Property(
     *      title="process_id",
     *      description="process id of task timesheet",
     *      example=1
     * )
     *
     * @var integer
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
            '*.work_time' => 'sometimes',
            '*.number_working' => 'sometimes',
            '*.number_actual_time' => 'sometimes',
            '*.note' => 'sometimes|max:4000',
            '*.created_at' => 'sometimes',
            '*.updated_at' => 'sometimes',
            '*.created_by' => 'sometimes',
            '*.updated_by' => 'sometimes',
            '*.process_id' => 'sometimes',
        ];
    }
}
