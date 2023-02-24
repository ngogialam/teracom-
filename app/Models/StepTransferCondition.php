<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Process.
 *
 * @package namespace App\Models;
 */

/**
 * @OA\Schema(
 *     title="StepTransferCondition",
 *     description="StepTransferCondition model",
 *     @OA\Xml(
 *         name="StepTransferCondition"
 *     )
 * )
 * @SuppressWarnings(PHPMD)
 */
class StepTransferCondition extends Model
{
    use HasFactory, SoftDeletes;

    const STEP_CONDITION_AND = 1;
    const STEP_CONDITION_OR = 2;

    const NEXT_STEP_TYPE_SINGLE = 1;
    const NEXT_STEP_TYPE_GROUP = 2;

    protected $dateFormat = 'U';

    protected $casts = [
        'created_at' => 'datetime:U',
        'updated_at' => 'datetime:U',
    ];

    protected $table = 'step_transfer_condition';
    protected $fillable = [
        'step_id',
        'step_condition',
        'step_order',
        'next_step_type',
        'group_condition_id',
        'created_at',
        'deleted_at'
    ];

    public function stepGroupConndition()
    {
        return $this->belongsTo(StepTransferCondition::class, 'group_condition_id', 'id');
    }
}
