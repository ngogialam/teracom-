<?php

namespace App\Presenters;

use App\Transformers\FlowsHistoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FlowsHistoryPresenter.
 *
 * @package namespace App\Presenters;
 */

/**
 * @OA\Schema(
 *     title="FlowsHistoryPresenter",
 *     description="History presenter",
 *     @OA\Xml(
 *         name="History"
 *     )
 * )
 */
class FlowsHistoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FlowsHistoryTransformer();
    }
}
