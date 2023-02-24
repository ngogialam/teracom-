<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketTaskLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $dateFormat = 'U';

    protected $table = 'ticket_task_log';
    protected $fillable = [
        'ticket_req_id',
        'task_id',
        'process_id',
        'step_id',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'deleted_at'
    ];
}
