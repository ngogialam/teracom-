<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProcessCommentsCreateRequest;
use App\Http\Requests\ProcessCommentsUpdateRequest;
use App\Repositories\ProcessCommentsRepository;
use App\Validators\ProcessCommentsValidator;

/**
 * Class ProcessCommentsController.
 *
 * @package namespace App\Http\Controllers\Api\V1;
 */
class ProcessCommentsController extends BaseController
{
}
