<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TicketRequestValidator.
 *
 * @package namespace App\Validators;
 */
class TicketRequestValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|max:250',
            'department_id' => 'required',
            'process_id' => 'required',
            'ticket_serial' => 'sometimes|max:250',
            'request_time' => 'sometimes',
            'finish_time' => 'sometimes',
            'priority' => 'required|in:1,2,3',
            'comment' => 'sometimes|max:4000',
            'ticket_action' => 'sometimes|in:1,2',
            'approval_status' => 'sometimes|in:0,1,2,3',
            'created_at' => 'sometimes',
            'updated_at' => 'sometimes',
            'created_by' => 'sometimes|integer|min:1',
            'updated_by' => 'sometimes|integer|min:1',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'sometimes|max:250',
            'department_id' => 'sometimes',
            'process_id' => 'sometimes',
            'ticket_serial' => 'sometimes|max:250',
            'request_time' => 'sometimes',
            'finish_time' => 'sometimes',
            'priority' => 'sometimes|in:1,2,3',
            'comment' => 'sometimes|max:4000',
            'ticket_action' => 'sometimes|in:1,2',
            'approval_status' => 'sometimes|in:0,1,2,3',
            'created_at' => 'sometimes',
            'updated_at' => 'sometimes',
            'created_by' => 'sometimes|integer|min:1',
            'updated_by' => 'sometimes|integer|min:1',
        ],
    ];
}
