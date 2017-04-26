<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Parcela extends Model implements Presentable
{
    use PresentableTrait;

    public $timestamps = true;
    protected $table = 'tbl_parcela';
    protected $fillable = ['tbl_movimentacao_id', 'data_pagamento', 'data_vencimento', 'valor_pago', 'numero_parcela','valor_parcela', 'status'];
    protected $hidden = [''];

    public function Movimento()
    {
        return $this->belongsTo(Movimento::Class, 'tbl_movimentacao_id', 'id');
    }

}
