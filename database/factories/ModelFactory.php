<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Entities\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Entities\Movimento::class, function (Faker\Generator $faker) {
  return [
    'tipo'        => $faker->word,
    'categoria'   => $faker->word,
    'descricao'   => $faker->sentence(3,true),
    'data_emissao'=> $faker->date
  ];
});

$factory->define(App\Entities\Parcela::class, function (Faker\Generator $faker) {
  return [
    'movimento_id'    => rand(1,10),
    'data_pagamento'  => null,
    'data_vencimento' => $faker->date,
    'valor_pago'      => null,
    'valor_parcela'   => $faker->randomFloat(2,10,100),
    'numero_parcela'  => rand(1,3),
    'status'          => 'à pagar'
  ];
});
