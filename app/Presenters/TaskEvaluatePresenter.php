<?php

namespace App\Presenters;

use App\Transformers\TaskEvaluateTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TaskEvaluatePresenter.
 *
 * @package namespace App\Presenters;
 */
class TaskEvaluatePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TaskEvaluateTransformer();
    }
}
