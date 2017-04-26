<?php

namespace App\Presenters;

use App\Transformers\MovimentoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MovimentoPresenter
 *
 * @package namespace App\Presenters;
 */
class MovimentoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MovimentoTransformer();
    }
}
