<?php

use Illuminate\Database\Seeder;

class MovimentoTableSeeder extends Seeder
{


    public function run()
    {
        //\App\Entities\Movimento::truncate();
        factory(\App\Entities\Movimento::class,10)->create()->each(function ($movimento){
            for ($i=0; $i < 3 ; $i++) {
                $movimento->Parcela()->save(factory(\App\Entities\Parcela::class)->make());
            }

        });
  }
}
