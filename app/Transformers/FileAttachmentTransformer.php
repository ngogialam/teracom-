<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\FileAttachment;

/**
 * Class FileAttachmentTransformer.
 *
 * @package namespace App\Transformers;
 */
class FileAttachmentTransformer extends TransformerAbstract
{
    /**
     * Transform the FileAttachment entity.
     *
     * @param \App\Models\FileAttachment $model
     *
     * @return array
     */
    public function transform(FileAttachment $model)
    {
        return [
            'id' => $model['id'],
            'file_name' => $model['file_name'],
            'file_uid' => $model['id'],
            'target_id' => $model['target_id'],
            'target_type' => $model['target_type'],
            'path' => $model['path'],
            'created_by' => $model['created_by'],
            'updated_by' => $model['updated_by'],
            'created_at' => convertTimeStamp($model['created_at']),
            'updated_at' => convertTimeStamp($model['updated_at']),
        ];
    }
}
