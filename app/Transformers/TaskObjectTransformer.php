<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TaskObject;

/**
 * Class TaskObjectTransformer.
 *
 * @package namespace App\Transformers;
 */
class TaskObjectTransformer extends TransformerAbstract
{
    /**
     * Transform the TaskObject entity.
     *
     * @param \App\Models\TaskObject $model
     *
     * @return array
     */
    public function transform(TaskObject $model)
    {
        return [
            'id' => $model['id'],
            'task_id' => $model['task_id'],
            'object_action_type' => $model['object_action_type'],
            'object_type' => $model['object_type'],
            'object_id' => $model['object_id'],
            'object_name' => $model['object_name'],
            'object_position' => $model['object_position'],
            'created_by' => $model['created_by'],
            'updated_by' => $model['updated_by'],
            'ticket_req_id' => $model['ticket_req_id'],
            'created_at' => convertTimeStamp($model['created_at']),
            'updated_at' => convertTimeStamp($model['updated_at']),
        ];
    }
}
