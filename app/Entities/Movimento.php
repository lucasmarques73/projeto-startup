<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Traits\PresentableTrait;

class Movimento extends Model implements Presentable
{
    use PresentableTrait;

    public $timestamps = true;
    protected $table = 'movimentos';
    protected $fillable = ['tipo','categoria', 'descricao', 'data_emissao'];
    protected $hidden = [''];

    public function Parcela()
    {
        return $this->hasMany(Parcela::Class, 'movimento_id', 'id');
    }

}
