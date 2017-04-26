<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Parcela;

/**
 * Class ParcelaTransformer
 * @package namespace App\Transformers;
 */
class ParcelaTransformer extends TransformerAbstract
{

    /**
     * Transform the \Parcela entity
     * @param \Parcela $model
     *
     * @return array
     */
    public function transform(Parcela $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
