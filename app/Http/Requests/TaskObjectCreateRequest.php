<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Task object create request",
 *      description="Task object create request body data",
 *      required={"task_id","object_type","object_id","created_by","created_at","ticket_req_id"},
 *      type="array",
 *         example={{
*                             "id": 4,
*                             "task_id": 2,
*                             "object_action_type": 2,
*                             "object_type": 2,
*                             "object_id": 2,
*                             "object_name": "sffsfđfs",
*                             "object_position": "2",
*                             "created_by": 2,
*                             "created_at": 2313234,
*                             "updated_at": 1331244,
*                             "updated_by": 2,
*                             "deleted_at": 2,
*                             "ticket_req_id": 2
*                            },
*                            {
*                             "id": 1,
*                             "task_id": 2,
*                             "object_action_type": 1,
*                             "object_type": 1,
*                             "object_id": 1,
*                             "object_name": "sffsfs",
*                             "object_position": "1",
*                             "created_by": 1,
*                             "created_at": 21234,
*                             "updated_at": 131244,
*                             "updated_by": 1,
*                             "deleted_at": 1,
*                             "ticket_req_id": 3
*                           }},
 *      @OA\Items()
 * )
 * @SuppressWarnings(PHPMD)
 */

class TaskObjectCreateRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="task_id",
     *      description="task id of task object",
     *      example=2
     * )
     *
     * @var integer
     */

    public $task_id;

    /**
     * @OA\Property(
     *      title="object_action_type",
     *      description="object action type of task object",
     *      example=2
     * )
     *
     * @var integer
     */

    public $object_action_type;
    /**
     * @OA\Property(
     *      title="object_type",
     *      description="object type of task object",
     *      example=2
     * )
     *
     * @var integer
     */

    public $object_type;

    /**
     * @OA\Property(
     *      title="object_id",
     *      description="object id of task object",
     *      example=2
     * )
     *
     * @var integer
     */

    public $object_id;

    /**
     * @OA\Property(
     *      title="object_name",
     *      description="object name of task object",
     *      example=2
     * )
     *
     * @var integer
     */

    public $object_name;

    /**
     * @OA\Property(
     *      title="object position",
     *      description="object position of task object",
     *      example="sffsfđfs"
     * )
     *
     * @var string
     */

    public $object_position;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="created at of task object",
     *      example=2
     * )
     *
     * @var int
     */

    public $created_at;

    /**
     * @OA\Property(
     *      title="updated_at",
     *      description="updated at of task object",
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
     *      description="updated by of task object",
     *      example=2
     * )
     *
     * @var integer
     */

    public $updated_by;
     /**
     * @OA\Property(
     *      title="deleted_at",
     *      description="deleted at of task object",
     *      example=2
     * )
     *
     * @var integer
     */

    public $deleted_at;

    /**
     * @OA\Property(
     *      title="ticket_req_id",
     *      description="ticket req id of task object",
     *      example=2
     * )
     *
     * @var integer
     */

    public $ticket_req_id;

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
            '*.task_id' => 'sometimes',
            '*.object_action_type' => 'sometimes|in:1,2,3',
            '*.object_type' => 'required',
            '*.object_id' => 'required',
            '*.object_name' => 'sometimes',
            '*.object_position' => 'sometimes',
            '*.created_by' => 'required',
            '*.created_at' => 'required',
            '*.updated_at' => 'sometimes',
            '*.updated_by' => 'sometimes',
            '*.deleted_at' => 'sometimes',
            '*.ticket_req_id' => 'sometimes'
        ];
    }
}
