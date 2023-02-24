<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ApprovalProcessLog;

/**
 * Class ProcessApproveTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProcessApproveTransformer extends TransformerAbstract
{
    /**
     * Transform the ProcessApprove entity.
     *
     * @param \App\Models\ApprovalProcessLog $model
     *
     * @return array
     */
    public function transform(ApprovalProcessLog $model)
    {
        return [
            'id'         => (int) $model->id,
            'process_id' => (int) $model->process_id,
            'approval_status' => $model['approval_status'],
            'comment' => $model->comment,
            'created_by'  => $model->created_by,
            'updated_by' => $model->updated_by,
            'email' => $model['email'],
            'name' => $model['name'],
            'created_at' => convertTimeStamp($model['created_at']),
            'updated_at' => convertTimeStamp($model['updated_at']),
        ];
    }
}
