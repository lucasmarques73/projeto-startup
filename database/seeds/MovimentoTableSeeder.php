<?php

use Illuminate\Database\Seeder;

class MovimentoTableSeeder extends Seeder
{


    public function run()
    {
        \App\Entities\Movimento::truncate();
        factoy(\App\Entities\Movimento::class, 10)->each(function($movimento){

        $movimento->Parcelas()->save(factoy(\App\Entities\Parcela::class)->make());
    })->create();





  }
}
