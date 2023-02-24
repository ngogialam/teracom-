<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class StepObjectValidator.
 *
 * @package namespace App\Validators;
 */
class StepObjectValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            '*.step_id' => 'sometimes',
            '*.object_action_type' => 'sometimes',
            '*.object_type' => 'sometimes',
            '*.object_id' => 'sometimes',
            '*.object_name' => 'sometimes',
            '*.object_position' => 'sometimes',
            '*.created_at' => 'sometimes',
            '*.status' => 'sometimes',
            '*.process_id' => 'sometimes',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
