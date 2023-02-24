<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessStep extends Model
{
    use HasFactory, SoftDeletes;

    const ACTION_TYPE_END = 0;
    const ACTION_TYPE_OFFER = 1;
    const ACTION_TYPE_FORWARD = 2;
    const ACTION_TYPE_APPROVE = 3;

    const STEP_TYPE_FINISH = 0;
    const STEP_TYPE_START = 1;
    const STEP_TYPE_PROCESS = 2;
    const STEP_TYPE_CHILD = 3;

    const SLA_UNIT_HOURS = 1;
    const SLA_UNIT_DAY = 2;
    const SLA_UNIT_DAY_WORK = 3;
    const SLA_UNIT_HOURS_WORK = 4;

    const TRANSFER_CONDITION_TYPE_ALL = 1;
    const TRANSFER_CONDITION_TYPE_SOMETIME = 2;

    const STATUS_PROCESSING = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_REJECT = 2;

    const TIME_SHEET_NO = 0;
    const TIME_SHEET_YES = 1;

    const JUMP_STEP = 1;

    public $timestamps = false;
    protected $dateFormat = 'U';

    protected $table = 'process_step';
    protected $fillable = [
        'process_id',
        'name',
        'action_type',
        'step_type',
        'step_order',
        'child_process_id',
        'sla_quantity',
        'sla_unit',
        'transfer_condition_type',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'status',
        'deleted_at',
        'timesheet'
    ];

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id', 'id');
    }

    public function childProcess()
    {
        return $this->hasOne(Process::class, 'child_process_id', 'id');
    }

    public function stepTransferConditions()
    {
        return $this->hasMany(StepTransferCondition::class, 'step_id', 'id');
    }

    public function stepCheckList()
    {
        return $this->hasMany(ProcessStep::class, 'id', 'step_id');
    }
}
