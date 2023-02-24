<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     title="StepObject",
 *     description="StepObject model",
 *     @OA\Xml(
 *         name="StepObject"
 *     )
 * )
 * @SuppressWarnings(PHPMD)
 */
class StepObject extends Model
{
    use HasFactory, SoftDeletes;

    const OBJECT_ACTION_TYPE_PROCESS_OWNERSHIP = 0;
    const OBJECT_ACTION_TYPE_EXECUTOR = 1;
    const OBJECT_ACTION_TYPE_RECEIVE_INFORMATION = 2;
    const OBJECT_ACTION_TYPE_APPROVE = 3;

    const ACTION_TYPE_END = 0;
    const ACTION_TYPE_OFFER = 1;
    const ACTION_TYPE_FORWARD = 2;
    const ACTION_TYPE_APPROVE = 3;

    const OBJECT_TYPE_POSITION = 1;
    const OBJECT_TYPE_USER_GROUP = 2;
    const OBJECT_TYPE_DEPARTMENT = 3;
    const OBJECT_TYPE_DEPARTMENT_AND_POSITION = 4;
    const OBJECT_TYPE_USER = 5;

    const NO_ACTIVE = 0;
    const ACTIVE = 1;

    protected $dateFormat = 'U';

    protected $table = 'step_object';
    protected $fillable = [
        'step_id',
        'object_action_type',
        'object_type',
        'object_id',
        'object_name',
        'object_position',
        'created_at',
        'deleted_at',
        'status',
        'process_id',
        'active'
    ];


    public function processStep()
    {
        return $this->belongsTo(ProcessStep::class, 'step_id', 'id');
    }

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id', 'id');
    }
}
