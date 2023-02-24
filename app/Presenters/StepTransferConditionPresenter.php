<?php

namespace App\Presenters;

use App\Transformers\StepTransferConditionTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StepTransferConditionPresenter.
 *
 * @package namespace App\Presenters;
 */
class StepTransferConditionPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StepTransferConditionTransformer();
    }
}
