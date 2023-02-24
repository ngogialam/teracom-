<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TaskObjectValidator.
 *
 * @package namespace App\Validators;
 */
class TaskObjectValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            '*.task_id' => 'sometimes',
            '*.object_action_type' => 'sometimes|in:1,2,3',
            '*.object_type' => 'required',
            '*.object_id' => 'required',
            '*.object_name' => 'sometimes',
            '*.object_position' => 'sometimes',
            '*.created_by' => 'required',
            '*.created_at' => 'required',
            '*.updated_at' => 'sometimes',
            '*.updated_by' => 'sometimes',
            '*.deleted_at' => 'sometimes',
            '*.ticket_req_id' => 'sometimes'
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
