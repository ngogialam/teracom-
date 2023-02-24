<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProcessComments;

/**
 * Class ProcessCommentsTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProcessCommentsTransformer extends TransformerAbstract
{
    /**
     * Transform the ProcessComments entity.
     *
     * @param \App\Models\ProcessComments $model
     *
     * @return array
     */
    public function transform(ProcessComments $model): array
    {
        return [
            'id'         => (int) $model->id,
            'process_id' => $model->process_id,
            'comment'    => $model->comment,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
