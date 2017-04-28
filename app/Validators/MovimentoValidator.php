<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class MovimentoValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
          'tipo'          => 'required',
          'categoria'     => 'required',
          'descricao'     => 'required', 
          'data_emissao'  => 'required|date'
        ],
        ValidatorInterface::RULE_UPDATE => [],
   ];
}
