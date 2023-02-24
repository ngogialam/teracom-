<?php

namespace App\Presenters;

use App\Transformers\TicketHistoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TicketHistoryPresenter.
 *
 * @package namespace App\Presenters;
 */
/**
 * @OA\Schema(
 *     title="TicketHistoryPresenter",
 *     description="TicketHistory presenter",
 *     @OA\Xml(
 *         name="TicketHistory"
 *     )
 * )
 */
class TicketHistoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TicketHistoryTransformer();
    }
}
