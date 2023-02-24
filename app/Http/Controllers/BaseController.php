<?php

namespace App\Http\Controllers;

use App\Traits\ResponseTrait;

/**
 * @OA\Info(title="GPMS-Gprocess API", version="0.1", description="GPMS-Gprocess API")
 */
class BaseController extends Controller
{
    use ResponseTrait;

    const DEFAULT_LIMIT = 10;
    const DEFAULT_PAGE = 1;
    const LAST_PROCESS_STEP = 0;
    const START_PROCESS_STEP = 1;
}
