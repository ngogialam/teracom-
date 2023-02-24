<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProcessChangeLog;

/**
 * Class ProcessChangeLogTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProcessChangeLogTransformer extends TransformerAbstract
{
    /**
     * Transform the ProcessChangeLog entity.
     *
     * @param \App\Models\ProcessChangeLog $model
     *
     * @return array
     */
    public function transform(ProcessChangeLog $model): array
    {
        return [
            'id'         => (int) $model['id'],
            'process_id' => $model['process_id'],
            'description' => $model['description'],
            'created_by' => $model['created_by'],
            'updated_by' => $model['updated_by'],
            'change_type' => $model['change_type'],
            'version' => $model['version'],
            'old_version' => $model['old_version'],
            'email' => $model['email'],
            'name' => $model['name'],
            'created_at' => convertTimeStamp($model['created_at']),
            'updated_at' => convertTimeStamp($model['updated_at']),
        ];
    }
}
