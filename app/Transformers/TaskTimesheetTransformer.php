<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TaskTimesheet;

/**
 * Class TaskTimesheetTransformer.
 *
 * @package namespace App\Transformers;
 */
class TaskTimesheetTransformer extends TransformerAbstract
{
    /**
     * Transform the TaskTimesheet entity.
     *
     * @param \App\Models\TaskTimesheet $model
     *
     * @return array
     */
    public function transform(TaskTimesheet $model)
    {
        return [
            'id' => $model['id'],
            'work_time' => $model['work_time'],
            'number_working' => $model['number_working'],
            'number_actual_time' => $model['number_actual_time'],
            'note' => $model['note'],
            'created_by' => $model['created_by'],
            'updated_by' => $model['updated_by'],
            'process_id' => $model['process_id'],
            'created_at' => convertTimeStamp($model['created_at']),
            'updated_at' => convertTimeStamp($model['updated_at']),
        ];
    }
}
