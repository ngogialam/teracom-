<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\StepObject;

/**
 * Class StepObjectTransformer.
 *
 * @package namespace App\Transformers;
 */
class StepObjectTransformer extends TransformerAbstract
{
    /**
     * Transform the StepObject entity.
     *
     * @param \App\Models\StepObject $model
     *
     * @return array
     */
    public function transform(StepObject $model)
    {
        return [
            'id' => $model['id'],
            'step_id' => $model['step_id'],
            'object_action_type' => $model['object_action_type'],
            'object_type' => $model['object_type'],
            'object_id' => $model['object_id'],
            'object_name' => $model['object_name'],
            'object_position' => $model['object_position'],
            'status' => $model['status'],
            'active' => $model['active'],
            'process_id' => $model['process_id'],
            'process_step' => $model['processStep'],
            'process' => $model['process'] ?? null
        ];
    }
}
