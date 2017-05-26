<?php

use Illuminate\Database\Seeder;

class ParcelaTableSeeder extends Seeder
{
  public function run()
  {
    \App\Entities\Parcela::truncate();
    factoy(\App\Entities\Parcela::class, 10)->create();
  }
}
