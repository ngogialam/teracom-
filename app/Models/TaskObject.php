<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskObject extends Model
{
    use HasFactory, SoftDeletes;

    const OBJECT_ACTION_TYPE_WORK_STEP = 1;
    const OBJECT_ACTION_TYPE_INFOMATION_STEP = 2;
    const OBJECT_ACTION_TYPE_INFOMATION_USER = 3;
    const OBJECT_ACTION_TYPE_INFOMATION_USER_GROUP = 4;
    const OBJECT_ACTION_TYPE_USER_NEXT_STEP = 5;

    const OBJECT_TYPE_POSITION = 1;
    const OBJECT_TYPE_USER_GROUP = 2;
    const OBJECT_TYPE_DEPARTMENT = 3;
    const OBJECT_TYPE_DEPARTMENT_AND_POSITION = 4;
    const OBJECT_TYPE_USER = 5;

    protected $dateFormat = 'U';

    protected $table = 'task_object';
    protected $fillable = [
        'task_id',
        'object_action_type',
        'object_type',
        'object_id',
        'object_name',
        'object_position',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'deleted_at',
        'ticket_req_id'
    ];
}
