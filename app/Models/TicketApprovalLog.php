<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketApprovalLog extends Model
{
    use HasFactory, SoftDeletes;

    const APPROVAL_STATUS_DRAFT = 0;
    const APPROVAL_STATUS_WAITING = 1;
    const APPROVAL_STATUS_APPROVE = 2;
    const APPROVAL_STATUS_REJECT = 3;

    protected $table = 'ticket_approval_log';
    protected $dateFormat = 'U';
    protected $fillable = [
        'ticket_req_id',
        'approval_status',
        'comment',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'deleted_at'
    ];

    public function ticketRequest()
    {
        return $this->belongsTo(TicketRequest::class);
    }
}
