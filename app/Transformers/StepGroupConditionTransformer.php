<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\StepGroupCondition;

/**
 * Class StepGroupConditionTransformer.
 *
 * @package namespace App\Transformers;
 */
class StepGroupConditionTransformer extends TransformerAbstract
{
    /**
     * Transform the StepGroupCondition entity.
     *
     * @param \App\Models\StepGroupCondition $model
     *
     * @return array
     */
    public function transform(StepGroupCondition $model)
    {
        return [
            'id' => $model['id'],
            'group_first_step' => $model['group_first_step'],
            'step_condition' => $model['step_condition'],
            'step_order' => $model['step_order'],
            'created_at' => convertTimeStamp($model['created_at']),
            'stepTransferCondition' => $model['stepTransferCondition'] ?? null
        ];
    }
}
