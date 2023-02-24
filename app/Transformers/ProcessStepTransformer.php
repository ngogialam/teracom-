<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProcessStep;

/**
 * Class ProcessStepTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProcessStepTransformer extends TransformerAbstract
{
    /**
     * Transform the ProcessStep entity.
     *
     * @param \App\Models\ProcessStep $model
     *
     * @return array
     */
    public function transform(ProcessStep $model): array
    {
        return [
            'id' => $model['id'],
            'process_id' => $model['process_id'],
            'name' => $model['name'],
            'action_type' => $model['action_type'],
            'step_type' => $model['step_type'],
            'step_order' => $model['step_order'],
            'child_process_id' => $model['child_process_id'],
            'sla_quantity' => $model['sla_quantity'],
            'sla_unit' => $model['sla_unit'],
            'transfer_condition_type' => $model['transfer_condition_type'],
            'created_by' => $model['created_by'],
            'updated_by' => $model['updated_by'],
            'status' => $model['status'],
            'timesheet' => $model['timesheet'],
            'created_at' => convertTimeStamp($model['created_at']),
            'updated_at' => convertTimeStamp($model['updated_at']),
            'stepTransferConditions' => $model['stepTransferConditions'] ?? null,
            'fileAttachments' => $model['fileAttachments'] ?? null,
        ];
    }
}
