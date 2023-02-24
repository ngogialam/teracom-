<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TicketRequest;

/**
 * Class TicketRequestTransformer.
 *
 * @package namespace App\Transformers;
 */
class TicketRequestTransformer extends TransformerAbstract
{
    /**
     * Transform the TicketRequest entity.
     *
     * @param \App\Models\TicketRequest $model
     *
     * @return array
     */
    public function transform(TicketRequest $model)
    {
        return [
            'id' => $model['id'],
            'name' => $model['name'],
            'department_id' => $model['department_id'],
            'process_id' => $model['process_id'],
            'ticket_serial' => $model['ticket_serial'],
            'request_time' => $model['request_time'],
            'finish_time' => $model['finish_time'],
            'priority' => $model['priority'],
            'comment' => $model['comment'],
            'ticket_action' => $model['ticket_action'],
            'approval_status' => $model['approval_status'],
            'created_by' => $model['created_by'],
            'updated_by' => $model['updated_by'],
            'complete' => $model['complete'],
            'ticket_type' => $model['ticket_type'],
            'code' => $model['code'],
            'created_at' => convertTimeStamp($model['created_at']),
            'updated_at' => convertTimeStamp($model['updated_at']),
            'tasks' => $model['tasks'] ?? null,
            'process' => $model['process'] ?? null,
            'object' => $this->getObjects($model) ?? null,
        ];
    }

    private function getObjects(object $model): array
    {
        $objects = [];
        foreach ($model['objects'] as $object) {
            if ($object->task_id == null) {
                array_push($objects, $object);
            }
        }

        return $objects;
    }
}
