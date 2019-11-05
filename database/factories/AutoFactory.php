<?php

use Faker\Generator as Faker;

$factory->define(App\Auto::class, function (Faker $faker) {

     return [
        'marca' => $faker->sentence(2),
        'modelo' => $faker->sentence(3),
        'anio' => rand(2000,2019),
    ];


});
