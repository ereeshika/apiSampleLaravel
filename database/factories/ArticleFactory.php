<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'details' => $faker->text(340),
        'price' => $faker->numberBetween(100, 1000),
        'availableCopies' => $faker->randomDigit,
        'discount' => $faker->numberBetween(5, 25)
    ];
});
