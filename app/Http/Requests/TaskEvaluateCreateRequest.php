<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Task evaluate create request",
 *      description="Task evaluate create request body data",
 *      required={"task_id"},
 *      type="array",
 *         example={{
 *                             "task_id": 6,
 *                             "process_id": 1,
 *                             "step_id": 2,
 *                             "rate": 1,
 *                             "comment": "aaaaaa",
 *                             "created_at": 1222433,
 *                             "updated_at": 1222433,
 *                             "deleted_at": 1234433,
 *                             "created_by": 1233223,
 *                             "updated_by": 14
 *                   },
 *                   {
 *                             "task_id": 7,
 *                             "process_id": 1,
 *                             "step_id": 2,
 *                             "rate": 1,
 *                             "comment": "no comment",
 *                             "created_at": 1223333,
 *                             "updated_at": 1223333,
 *                             "deleted_at": 1233333,
 *                             "created_by": 1233333,
 *                             "updated_by": 13
 *                   },
 *                 },
 *      @OA\Items()
 * )
 * @SuppressWarnings(PHPMD)
 */

class TaskEvaluateCreateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="task_id",
     *      description="task id of task evaluate",
     *      example=2
     * )
     *
     * @var integer
     */

    public $task_id;

    /**
     * @OA\Property(
     *      title="process_id",
     *      description="process id of task evaluate",
     *      example=2
     * )
     *
     * @var integer
     */

    public $process_id;
    /**
     * @OA\Property(
     *      title="step_id",
     *      description="process step id of task evaluate",
     *      example=2
     * )
     *
     * @var integer
     */

    public $step_id;

    /**
     * @OA\Property(
     *      title="rate",
     *      description="rate of task evaluate",
     *      example=2
     * )
     *
     * @var integer
     */

    public $rate;

    /**
     * @OA\Property(
     *      title="comment",
     *      description="comment of task evaluate",
     *      example="sffsfđfs"
     * )
     *
     * @var string
     */

    public $comment;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="created at of task evaluate",
     *      example=2
     * )
     *
     * @var int
     */

    public $created_at;

    /**
     * @OA\Property(
     *      title="updated_at",
     *      description="updated at of task evaluate",
     *      example=2313234
     * )
     *
     * @var int
     */

    public $updated_at;

    /**
     * @OA\Property(
     *      title="created_by",
     *      description="created by of task object",
     *      example=1331244
     * )
     *
     * @var integer
     */

    public $created_by;

    /**
     * @OA\Property(
     *      title="updated_by",
     *      description="updated by of task evaluate",
     *      example=2
     * )
     *
     * @var integer
     */

    public $updated_by;
    /**
     * @OA\Property(
     *      title="deleted_at",
     *      description="deleted at of task evaluate",
     *      example=2
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
            'task_id' => 'sometimes',
            'process_id' => 'sometimes',
            'process_step_id' => 'sometimes',
            'rate' => 'sometimes|in:1,2,3,4,5',
            'comment' => 'sometimes',
            'created_at' => 'sometimes',
            'updated_at' => 'sometimes',
            'deleted_at' => 'sometimes',
            'created_by' => 'sometimes',
            'updated_by' => 'sometimes',
        ];
    }
}
