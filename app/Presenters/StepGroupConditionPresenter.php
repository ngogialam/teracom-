<?php

namespace App\Presenters;

use App\Transformers\StepGroupConditionTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StepGroupConditionPresenter.
 *
 * @package namespace App\Presenters;
 */
class StepGroupConditionPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StepGroupConditionTransformer();
    }
}
