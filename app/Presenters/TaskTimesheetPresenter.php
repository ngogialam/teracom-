<?php

namespace App\Presenters;

use App\Transformers\TaskTimesheetTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TaskTimesheetPresenter.
 *
 * @package namespace App\Presenters;
 */

/**
 * @OA\Schema(
 *     title="TaskTimeSheetPresenter",
 *     description="Task timesheet presenter",
 *     @OA\Xml(
 *         name="TaskTimesheet"
 *     )
 * )
 */

class TaskTimesheetPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TaskTimesheetTransformer();
    }
}
