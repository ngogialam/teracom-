<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Prettus\Repository\Traits\PresentableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ProcessStep;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Process.
 *
 * @package namespace App\Models;
 */

/**
 * @OA\Schema(
 *     title="Process",
 *     description="Process model",
 *     @OA\Xml(
 *         name="Process"
 *     )
 * )
 * @SuppressWarnings(PHPMD)
 */

class Process extends Model implements Transformable
{
    use HasFactory, TransformableTrait, PresentableTrait, SoftDeletes;

    const TARGET_APPLY_TYPE_SYSTEM = 1;
    const TARGET_APPLY_TYPE_INTERNAL = 2;

    const APPROVAL_STATUS_DRAFT = 1;
    const APPROVAL_STATUS_WAITING = 2;
    const APPROVAL_STATUS_APPROVE = 3;
    const APPROVAL_STATUS_REJECT = 4;
    const APPROVAL_STATUS_EXPIRE = 5;

    const STATUS_ACTIVATED = 0;
    const STATUS_STOP = 1;

    const NO_OUT_OF_DATE = 0;
    const OUT_OF_DATE = 1;

    protected $dateFormat = 'U';

    const VERSION_DEFAULT = '1.0';

    protected $casts = [
        'created_at' => 'datetime:U',
        'updated_at' => 'datetime:U',
    ];

    protected $table = 'process';

    /**
     * @OA\Property(
     *      title="Id",
     *      description="ID of the Process",
     *      example=1
     * )
     *
     * @var integer
     */
    public $id;
    /**
     * @OA\Property(
     *      title="Code",
     *      description="Code of the Process",
     *      example="ABC123"
     * )
     *
     * @var integer
     */
    public $code;
    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the Process",
     *      example="A nice process"
     * )
     *
     * @var string
     */
    public $name;
    /**
     * @OA\Property(
     *      title="Short Name",
     *      description="Short Name of the Process",
     *      example="Nice process"
     * )
     *
     * @var string
     */
    public $short_name;
    /**
     * @OA\Property(
     *      title="Owner Department ID",
     *      description="Owner Department ID of the Process",
     *      example="1"
     * )
     *
     * @var string
     */
    public $owner_deparment_id;
    /**
     * @OA\Property(
     *      title="Target Apply Type",
     *      description="Target Apply Type of the Process",
     *      example="1"
     * )
     *
     * @var string
     */
    public $target_apply_type;
    /**
     * @OA\Property(
     *      title="Regulation Document",
     *      description="Regulation Document of the Process",
     *      example="Good guide"
     * )
     *
     * @var string
     */
    public $regulation_document;
    /**
     * @OA\Property(
     *      title="Regulation Start Date",
     *      description="Regulation Start Date of the Process",
     *      example=1234567
     * )
     *
     * @var string
     */
    public $regulation_start_date;
    /**
     * @OA\Property(
     *      title="Regulation End Date",
     *      description="Regulation End Date of the Process",
     *      example=1234567
     * )
     *
     * @var string
     */
    public $regulation_end_date;
    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the Process",
     *      example="This is good process"
     * )
     *
     * @var string
     */
    public $description;
    /**
     * @OA\Property(
     *      title="Approval Status",
     *      description="Approval Status of the Process",
     *      example="1"
     * )
     *
     * @var string
     */
    public $approval_status;
    /**
     * @OA\Property(
     *      title="Approval Target Type",
     *      description="Approval Target Type of the Process",
     *      example="1"
     * )
     *
     * @var string
     */
    public $approval_target_type;
    /**
     * @OA\Property(
     *      title="Delete At",
     *      description="Delete At of the Process",
     *      example=1234567
     * )
     *
     * @var string
     */
    public $deleted_at;
    /**
     * @OA\Property(
     *      title="Version",
     *      description="Version of the Process",
     *      example="1"
     * )
     *
     * @var string
     */
    public $version;
    /**
     * @OA\Property(
     *      title="process_id",
     *      description="Id of old version of the process",
     *      example=1
     * )
     *
     * @var integer
     */

    public $process_id;
    /**
     * @OA\Property(
     *      title="Created By",
     *      description="Created By of the Process",
     *      example=2570871942
     * )
     *
     * @var string
     */
    public $created_by;
    /**
     * @OA\Property(
     *      title="Updated By",
     *      description="Updated By of the Process",
     *      example=2570871942
     * )
     *
     * @var string
     */
    public $updated_by;
    /**
     * @OA\Property(
     *      title="Status",
     *      description="Status of the Process",
     *      example=1
     * )
     *
     * @var string
     */
    public $status;

    protected $fillable = [
        'code',
        'name',
        'short_name',
        'owner_deparment_id',
        'target_apply_type',
        'regulation_document',
        'regulation_start_date',
        'regulation_end_date',
        'description',
        'approval_status',
        'approval_target_type',
        'deleted_at',
        'version',
        'process_id',
        'created_by',
        'created_at',
        'updated_at',
        'updated_by',
        'status',
        'required_time',
        'request_completion_time',
        'out_of_date',
        'activation_date',
        'process_code'
    ];

    public function processChangeLogs()
    {
        return $this->hasMany(ProcessChangeLog::class, 'process_id', 'id');
    }

    public function approvalProcessLogs()
    {
        return $this->hasMany(ApprovalProcessLog::class, 'process_id', 'id');
    }

    public function processSteps()
    {
        return $this->hasMany(ProcessStep::class, 'process_id', 'id');
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, TicketRequest::class, 'process_id', 'ticket_req_id', 'id');
    }

    public function stepObject()
    {
        return $this->hasMany(StepObject::class, 'process_id', 'id');
    }

    public function stepTransferCondition()
    {
        return $this->hasManyThrough(StepTransferCondition::class, ProcessStep::class, 'process_id', 'step_id', 'id');
    }

    public function stepCheckList()
    {
        return $this->hasManyThrough(StepChecklist::class, ProcessStep::class, 'process_id', 'step_id', 'id');
    }

    public function ticketRequest()
    {
        return $this->hasMany(TicketRequest::class, 'process_id', 'id');
    }

    public function processComment()
    {
        return $this->hasOne(ProcessComments::class, 'process_id', 'id');
    }
}
