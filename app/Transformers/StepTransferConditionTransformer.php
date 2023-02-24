<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\StepTransferCondition;

/**
 * Class StepTransferConditionTransformer.
 *
 * @package namespace App\Transformers;
 */
class StepTransferConditionTransformer extends TransformerAbstract
{
    /**
     * Transform the StepTransferCondition entity.
     *
     * @param \App\Models\StepTransferCondition $model
     *
     * @return array
     */
    public function transform(StepTransferCondition $model)
    {
        return [
            'id' => $model['id'],
            'step_id' => $model['step_id'],
            'step_condition' => $model['step_condition'],
            'step_order' => $model['step_order'],
            'next_step_type' => $model['next_step_type'],
            'group_condition_id' => $model['group_condition_id'],
            'created_at' => convertTimeStamp($model['created_at']),
            'stepGroupConndition' => $model['stepGroupConndition'] ?? null
        ];
    }
}
