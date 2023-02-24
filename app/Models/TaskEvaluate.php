<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskEvaluate extends Model
{
    use HasFactory, SoftDeletes;

    protected $dateFormat = 'U';
    protected $table = 'task_evaluate';
    protected $fillable = [
        'task_id',
        'process_id',
        'step_id',
        'rate',
        'comment',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'deleted_at'
    ];
}
