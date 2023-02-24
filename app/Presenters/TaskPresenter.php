<?php

namespace App\Presenters;

use App\Transformers\TaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TaskPresenter.
 *
 * @package namespace App\Presenters;
 */

/**
 * @OA\Schema(
 *     title="TaskPresenter",
 *     description="Task presenter",
 *     @OA\Xml(
 *         name="Task"
 *     )
 * )
 */
class TaskPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TaskTransformer();
    }
}
