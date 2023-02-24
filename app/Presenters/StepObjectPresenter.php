<?php

namespace App\Presenters;

use App\Transformers\StepObjectTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StepObjectPresenter.
 *
 * @package namespace App\Presenters;
 */

 /**
* @OA\Schema(
*     title="StepObjectPresenter",
*     description="Step Object presenter",
*     @OA\Xml(
*         name="StepObject"
*     )
* )
*/
class StepObjectPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StepObjectTransformer();
    }
}
