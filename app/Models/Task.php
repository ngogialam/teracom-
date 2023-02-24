<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    const TASK_NORMAL = '1';
    const TASK_AUTO = '2';

    const TASK_ACTION_NOTHING = 1;
    const TASK_ACTION_FORWARD = 2;
    const TASK_ACTION_APPROVE = 3;

    const APPROVAL_STATUS_DRAFT = 0;
    const APPROVAL_STATUS_FORWARD = 1;
    const APPROVAL_STATUS_APPROVE = 2;
    const APPROVAL_STATUS_REJECT = 3;

    const ROLLBACK_TYPE_SPECIFID = 1;
    const ROLLBACK_TYPE_SEQUENTIALLY = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_COMPLETE = 2;
    const STATUS_CLOSED = 3;

    const STEP_SHORT_NAME = 'b';

    const TASK_OF_STEP_FIRST = '1';

    public $timestamps = false;

    protected $table = 'task';
    protected $fillable = [
        'ticket_req_id',
        'step_id',
        'task_type',
        'assignee_id',
        'department_id',
        'actual_complete_time',
        'expected_complete_time',
        'action',
        'approval_status',
        'rollback_step_id',
        'rollback_type',
        'comment',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'status',
        'auto_ticket_req_id',
        'code'
    ];

    public function tickectRequest()
    {
        return $this->belongsTo(TicketRequest::class, 'ticket_req_id', 'id');
    }

    public function process()
    {
        if (!empty($this->tickectRequest)) {
            return $this->tickectRequest->process();
        }
    }

    public function processStep()
    {
        return $this->belongsTo(ProcessStep::class, 'step_id', 'id');
    }

    public function taskObject()
    {
        return $this->hasMany(TaskObject::class, 'task_id', 'id');
    }
}
