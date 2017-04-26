<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Parcela extends Model implements Presentable
{
    use PresentableTrait;

    public $timestamps = true;
    protected $table = 'parcelas';
    protected $fillable = ['movimento_id', 'data_pagamento', 'data_vencimento', 'valor_pago', 'numero_parcela','valor_parcela', 'status'];
    protected $hidden = [''];

    public function Movimento()
    {
        return $this->belongsTo(Movimento::Class, 'movimento_id', 'id');
    }

}
