<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalProcessLog extends Model
{
    use HasFactory;

    const APPROVE_STATUS_DOING = 0;
    const APPROVE_STATUS_SEND = 1;
    const APPROVE_STATUS_COMPLETED = 2;
    const APPROVE_STATUS_DENIED = 3;

    const DEFAULT_NAME = 'admin';
    const DEFAULT_EMAIL = 'admin@ggg.com.vn';

    public $timestamps = false;

    protected $table = 'process_approval_log';
    protected $fillable = [
        'name',
        'process_id',
        'approval_status',
        'comment',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'email'
    ];

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function childProcess()
    {
        return $this->hasOne(Process::class, 'child_process_id', 'id');
    }
}
