<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TaskTimesheet.
 *
 * @package namespace App\Models;
 */
class TaskTimesheet extends Model implements Transformable
{
    use TransformableTrait, HasFactory, SoftDeletes;

    protected $dateFormat = 'U';
    protected $table = 'task_timesheet';
    protected $fillable = [
        'work_time',
        'number_working',
        'number_actual_time',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'process_id'
    ];

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id', 'id');
    }
}
