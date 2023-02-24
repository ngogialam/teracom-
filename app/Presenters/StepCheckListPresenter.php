<?php

namespace App\Presenters;

use App\Transformers\StepCheckListTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StepCheckListPresenter.
 *
 * @package namespace App\Presenters;
 */
class StepCheckListPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StepCheckListTransformer();
    }
}
