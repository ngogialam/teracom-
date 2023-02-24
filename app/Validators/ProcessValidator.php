<?php

namespace App\Validators;

use \Prettus\Validator\LaravelValidator;
use \Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class ProcessValidator.
 *
 * @package namespace App\Validators;
 */
class ProcessValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'code' => 'required|min:6,max:49',
            'name' => 'required|max:250',
            'short_name' => 'required|max:20',
            'owner_deparment_id' => 'required',
            'target_apply_type' => 'required|in:1,2',
            'regulation_document' => 'sometimes|max:250',
            'regulation_start_date' => 'sometimes',
            'regulation_end_date' => 'sometimes',
            'description' => 'sometimes',
            'approval_status' => 'sometimes',
            'approval_target_type' => 'sometimes|in:1,2',
            'version' => 'sometimes',
            'process_id' => 'sometimes',
            'created_at' => 'required',
            'updated_at' => 'sometimes',
            'created_by' => 'required|integer|min:1',
            'updated_by' => 'sometimes',
            'status' => 'sometimes|in:0,1',
            'process_steps.*.name' => 'sometimes|max:250',
            'process_steps.*.action_type' => 'required_with:name|in:0,1,2,3',
            'process_steps.*.step_type' => 'required_with:name|in:0,1,2,3',
            'process_steps.*.step_order' => 'required',
            'process_steps.*.child_process_id' => 'sometimes',
            'process_steps.*.sla_quantity' => 'sometimes',
            'process_steps.*.sla_unit' => 'sometimes|in:1,2,3',
            'process_steps.*.transfer_condition_type' => 'sometimes|in:1,2',
            'process_steps.*.created_by' => 'sometimes',
            'process_steps.*.created_at' => 'sometimes',
            'process_steps.*.updated_at' => 'sometimes',
            'process_steps.*.updated_by' => 'sometimes',
            'process_steps.*.status' => 'sometimes|in:0,1,2',
            'timesheet' => 'sometimes|in:0,1',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
