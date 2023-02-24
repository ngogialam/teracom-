<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TicketRequest.
 *
 * @package namespace App\Models;
 */
class TicketRequest extends Model implements Transformable
{
    use TransformableTrait, HasFactory, SoftDeletes;

    protected $dateFormat = 'U';

    const PRIORITY_LOW = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH = 3;

    const TICKET_ACTION_NOTHING = 1;
    const TICKET_ACTION_FORWARD = 2;

    const APPROVAL_STATUS_DRAFT = 0;
    const APPROVAL_STATUS_PROCESSING = 1;
    const APPROVAL_STATUS_COMPLETED = 2;
    const APPROVAL_STATUS_REJECT = 3;
    const APPROVAL_STATUS_ALL = 4;

    const TICKET_TYPE_NOMAL = 1;
    const TICKET_TYPE_AUTO = 2;

    const TICKET_REQUEST_FIRST = '000001';

    const NUMBER_OF_CHARACTERS = 6;

    protected $casts = [
        'created_at' => 'datetime:U',
        'updated_at' => 'datetime:U',
    ];

    protected $table = 'ticket_request';
    protected $fillable = [
        'name',
        'department_id',
        'process_id',
        'ticket_serial',
        'request_time',
        'finish_time',
        'priority',
        'comment',
        'ticket_action',
        'approval_status',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'deleted_at',
        'complete',
        'ticket_type',
        'code'
    ];

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'ticket_req_id', 'id');
    }

    public function ticketApprovalLogs()
    {
        return $this->hasMany(TicketApprovalLog::class, 'ticket_req_id', 'id');
    }

    public function objects()
    {
        return $this->hasMany(TaskObject::class, 'ticket_req_id', 'id');
    }
}
