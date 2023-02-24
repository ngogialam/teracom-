<?php

namespace App\Presenters;

use App\Transformers\ProcessStepTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProcessStepPresenter.
 *
 * @package namespace App\Presenters;
 */

  /**
 * @OA\Schema(
 *     title="ProcessStepPresenter",
 *     description="Process step presenter",
 *     @OA\Xml(
 *         name="ProcessStep"
 *     )
 * )
 */
class ProcessStepPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProcessStepTransformer();
    }
}
