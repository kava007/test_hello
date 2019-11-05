<?php

use Faker\Generator as Faker;

$factory->define(App\Cliente::class, function (Faker $faker) {
   
    return [
        'nombre' => $faker->name,
        'email' => $faker->safeEmail,
        'direccion' => $faker->address,
    ];


});
