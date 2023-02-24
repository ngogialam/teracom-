<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TaskEvaluateValidator.
 *
 * @package namespace App\Validators;
 */
class TaskEvaluateValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'task_id' => 'sometimes',
            'process_id' => 'sometimes',
            'process_step_id' => 'sometimes',
            'rate' => 'sometimes|in:1,2,3,4,5',
            'comment' => 'sometimes',
            'created_at' => 'sometimes',
            'updated_at' => 'sometimes',
            'deleted_at' => 'sometimes',
            'created_by' => 'sometimes',
            'updated_by' => 'sometimes',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
