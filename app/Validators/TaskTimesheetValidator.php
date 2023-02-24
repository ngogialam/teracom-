<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TaskTimesheetValidator.
 *
 * @package namespace App\Validators;
 */
class TaskTimesheetValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            '*.work_time' => 'sometimes',
            '*.number_working' => 'sometimes',
            '*.number_actual_time' => 'sometimes',
            '*.note' => 'sometimes|max:4000',
            '*.created_at' => 'sometimes',
            '*.updated_at' => 'sometimes',
            '*.created_by' => 'sometimes',
            '*.updated_by' => 'sometimes',
            '*.process_id' => 'sometimes',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
