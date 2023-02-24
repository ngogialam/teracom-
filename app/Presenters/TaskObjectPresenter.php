<?php

namespace App\Presenters;

use App\Transformers\TaskObjectTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TaskObjectPresenter.
 *
 * @package namespace App\Presenters;
 */
class TaskObjectPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TaskObjectTransformer();
    }
}
