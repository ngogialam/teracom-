<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TaskEvaluate;

/**
 * Class TaskEvaluateTransformer.
 *
 * @package namespace App\Transformers;
 */
class TaskEvaluateTransformer extends TransformerAbstract
{
    /**
     * Transform the TaskEvaluate entity.
     *
     * @param \App\Models\TaskEvaluate $model
     *
     * @return array
     */
    public function transform(TaskEvaluate $model)
    {
        return [
            'id' => $model['id'],
            'task_id' => $model['task_id'],
            'process_id' => $model['process_id'],
            'process_step_id' => $model['process_step_id'],
            'rate' => $model['rate'],
            'evaluate_comment' => $model['evaluate_comment'],
            'created_by' => $model['created_by'],
            'updated_by' => $model['updated_by'],
            'created_at' => convertTimeStamp($model['created_at']),
            'updated_at' => convertTimeStamp($model['updated_at']),
        ];
    }
}
