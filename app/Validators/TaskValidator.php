<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TaskValidator.
 *
 * @package namespace App\Validators;
 */
class TaskValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => [
            'ticket_req_id' => 'sometimes',
            'step_id' => 'sometimes',
            'task_type' => 'sometimes',
            'assignee_id' => 'sometimes',
            'department_id' => 'sometimes',
            'actual_completed_time' => 'sometimes',
            'actual_time' => 'sometimes',
            'action' => 'sometimes',
            'approval_status' => 'sometimes',
            'rollback_step_id' => 'sometimes',
            'rollback_type' => 'sometimes|in:1,2',
            'comment' => 'sometimes|max:4000',
            'status' => 'sometimes',
        ],
    ];
}
