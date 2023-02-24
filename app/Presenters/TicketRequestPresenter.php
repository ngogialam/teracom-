<?php

namespace App\Presenters;

use App\Transformers\TicketRequestTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TicketRequestPresenter.
 *
 * @package namespace App\Presenters;
 */

/**
 * @OA\Schema(
 *     title="TicketRequestPresenter",
 *     description="Ticket request presenter",
 *     @OA\Xml(
 *         name="TicketRequest"
 *     )
 * )
 */
class TicketRequestPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TicketRequestTransformer();
    }
}
