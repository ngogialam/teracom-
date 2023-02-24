<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ProcessStepValidator.
 *
 * @package namespace App\Validators;
 */
class ProcessStepValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'process_id' => 'required',
            'name' => 'required|max:250',
            'action_type' => 'required|in:0,1,2,3',
            'step_type' => 'required|in:0,1,2,3',
            'step_order' => 'required',
            'child_process_id' => 'sometimes',
            'sla_quantity' => 'sometimes',
            'sla_unit' => 'sometimes',
            'transfer_condition_type' => 'sometimes',
            'created_by' => 'sometimes',
            'created_at' => 'sometimes',
            'updated_at' => 'sometimes',
            'updated_by' => 'sometimes',
            'status' => 'sometimes',
            'timesheet' => 'sometimes',
            'step_transfer_conditions.*.step_condition' => 'sometimes',
            'step_transfer_conditions.*.step_order' => 'sometimes',
            'step_transfer_conditions.*.next_step_type' => 'sometimes',
            'step_transfer_conditions.*.group_condition_id' => 'sometimes',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
