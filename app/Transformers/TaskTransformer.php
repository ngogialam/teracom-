<?php

namespace App\Transformers;

use App\Models\ProcessStep;
use App\Models\StepChecklist;
use League\Fractal\TransformerAbstract;
use App\Models\Task;

/**
 * Class TaskTransformer.
 *
 * @package namespace App\Transformers;
 */
class TaskTransformer extends TransformerAbstract
{
    /**
     * Transform the Task entity.
     *
     * @param \App\Models\Task $model
     *
     * @return array
     */
    public function transform(Task $model)
    {
        return [
            'id' => $model['id'],
            'code' => $model['code'],
            'ticket_req_id' => $model['ticket_req_id'],
            'step_id' => $model['step_id'],
            'task_type' => $model['task_type'],
            'assignee_id' => $model['assignee_id'],
            'department_id' => $model['department_id'],
            'actual_complete_time' => $model['actual_complete_time'],
            'expected_complete_time' => $model['expected_complete_time'],
            'action' => $model['action'],
            'approval_status' => $model['approval_status'],
            'rollback_step_id' => $model['rollback_step_id'],
            'rollback_type' => $model['rollback_type'],
            'comment' => $model['comment'],
            'status' => $model['status'],
            'auto_ticket_req_id' => $model['auto_ticket_req_id'],
            'created_by' => $model['created_by'],
            'process' => $model['process'] ?? null,
            'taskObject' => $model['taskObject'] ?? null,
            'processStep' => $this->getProcessStep($model['processStep']),
            'tickectRequest' => $model['tickectRequest'] ?? null
        ];
    }

    public function getProcessStep($processStep): ProcessStep
    {
        if ($processStep === null) {
            return new ProcessStep();
        }

        $processStep->stepCheckList = StepChecklist::where('step_id', $processStep['id'])->get();
        return $processStep;
    }
}
