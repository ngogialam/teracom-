<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class FileAttachmentValidator.
 *
 * @package namespace App\Validators;
 */
class FileAttachmentValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'file_uid' => 'sometimes',
            'target_id' => 'sometimes',
            'target_type' => 'sometimes',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
