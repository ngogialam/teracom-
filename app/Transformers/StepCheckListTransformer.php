<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\StepChecklist;

/**
 * Class StepCheckListTransformer.
 *
 * @package namespace App\Transformers;
 */
class StepCheckListTransformer extends TransformerAbstract
{
    /**
     * Transform the StepCheckList entity.
     *
     * @param \App\Models\StepChecklist $model
     *
     * @return array
     */
    public function transform(StepChecklist $model)
    {
        return [
            'id'         => (int) $model->id,
            'content'    => $model->content,
            'created_at' => convertTimeStamp($model['created_at']),
        ];
    }
}
