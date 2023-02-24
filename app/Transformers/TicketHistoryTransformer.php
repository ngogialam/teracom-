<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TicketHistory;

/**
 * Class TicketHistoryTransformer.
 *
 * @package namespace App\Transformers;
 */
class TicketHistoryTransformer extends TransformerAbstract
{
    /**
     * Transform the TicketHistory entity.
     *
     * @param \App\Models\TicketHistory $model
     *
     * @return array
     */
    public function transform(TicketHistory $model)
    {
        return [
            'id'         => $model['id'],
            'ticket_request_id' => $model['ticket_request_id'],
            'approval_status' => $model['approval_status'],
            'approval_comments' => $model['approval_comments'],
            'created_by' => $model['created_by'],
            'updated_by' => $model['updated_by'],
            'created_at' => convertTimeStamp($model['created_at']),
            'updated_at' => convertTimeStamp($model['updated_at']),
        ];
    }
}
