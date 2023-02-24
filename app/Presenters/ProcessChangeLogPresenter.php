<?php

namespace App\Presenters;

use App\Transformers\ProcessChangeLogTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProcessChangeLogPresenter.
 *
 * @package namespace App\Presenters;
 */
class ProcessChangeLogPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProcessChangeLogTransformer();
    }
}
