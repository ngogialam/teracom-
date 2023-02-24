<?php

namespace App\Presenters;

use App\Transformers\ProcessApproveTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProcessApprovePresenter.
 *
 * @package namespace App\Presenters;
 */

/**
 * @OA\Schema(
 *     title="ProcessApprovePresenter",
 *     description="Approve presenter",
 *     @OA\Xml(
 *         name="Approve"
 *     )
 * )
 */
class ProcessApprovePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProcessApproveTransformer();
    }
}
