<?php

namespace App\Presenters;

use App\Transformers\ParcelaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ParcelaPresenter
 *
 * @package namespace App\Presenters;
 */
class ParcelaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ParcelaTransformer();
    }
}
