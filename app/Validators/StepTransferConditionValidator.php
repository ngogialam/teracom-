<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class StepTransferConditionValidator.
 *
 * @package namespace App\Validators;
 */
class StepTransferConditionValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'step_id' => 'sometimes',
            'step_condition' => 'sometimes',
            'step_order' => 'sometimes',
            'next_step_type' => 'sometimes',
            'group_condition_id' => 'sometimes',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
