<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TicketHistory.
 *
 * @package namespace App\Models;
 */
class TicketHistory extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $table = 'ticket_approval_log';
    protected $dateFormat = 'U';
    protected $fillable = [
        'id',
        'ticket_request_id',
        'approval_status',
        'approval_comments',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by'
    ];
}
