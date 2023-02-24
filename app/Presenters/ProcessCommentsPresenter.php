<?php

namespace App\Presenters;

use App\Transformers\ProcessCommentsTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProcessCommentsPresenter.
 *
 * @package namespace App\Presenters;
 */
class ProcessCommentsPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProcessCommentsTransformer();
    }
}
