<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StepGroupCondition extends Model
{
    use HasFactory, SoftDeletes;

    const STEP_CONDITION_AND = 1;
    const STEP_CONDITION_OR = 2;

    protected $dateFormat = 'U';
    protected $table = 'step_group_condition';
    protected $fillable = [
        'group_first_step',
        'step_condition',
        'step_order',
        'created_at',
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:U',
        'updated_at' => 'datetime:U',
    ];

    public function stepTransferCondition()
    {
        return $this->hasMany(StepTransferCondition::class, 'group_condition_id', 'id');
    }
}
