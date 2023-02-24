<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     title="StepChecklist",
 *     description="StepChecklist model",
 *     @OA\Xml(
 *         name="StepChecklist"
 *     )
 * )
 * @SuppressWarnings(PHPMD)
 */
class StepChecklist extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'step_checklist';

    protected $dateFormat = 'U';

    /**
     * @OA\Property(
     *      title="step_id",
     *      description="step_id of the StepChecklist",
     *      example=1
     * )
     *
     * @var integer
     */
    public $step_id;

    /**
     * @OA\Property(
     *      title="content",
     *      description="content of the StepChecklist",
     *      example="The Content"
     * )
     *
     * @var string
     */
    public $content;

    /**
     * @OA\Property(
     *      title="created_at",
     *      description="date created of the StepChecklist",
     *      example="12334353"
     * )
     *
     * @var integer
     */
    public $created_at;

    /**
     * @OA\Property(
     *      title="deleted_at",
     *      description="date deletion of the Process",
     *      example="45153645"
     * )
     *
     * @var integer
     */
    public $deleted_at;

    protected $fillable = [
        'step_id',
        'content',
        'created_at',
        'deleted_at'
    ];
}
