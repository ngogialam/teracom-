<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessChangeLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    const CHANGE_TYPE_DEFAULT = 0;
    const CHANGE_TYPE_DESTROY = 1;
    const CHANGE_TYPE_ACTIVE = 2;
    const CHANGE_TYPE_COPY = 3;
    const CHANGE_TYPE_NEW_VERSION = 4;
    const CHANGE_TYPE_APPROVE = 5;
    const CHANGE_TYPE_NEXT = 6;
    const CHANGE_TYPE_WAITING_APPROVE = 7;

    protected $table = 'process_change_log';
    protected $fillable = [
        'name',
        'process_id',
        'description',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'change_type',
        'version',
        'old_version',
        'email'
    ];

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id', 'id');
    }
}
