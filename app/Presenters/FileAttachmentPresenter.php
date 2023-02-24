<?php

namespace App\Presenters;

use App\Transformers\FileAttachmentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FileAttachmentPresenter.
 *
 * @package namespace App\Presenters;
 */
class FileAttachmentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FileAttachmentTransformer();
    }
}
