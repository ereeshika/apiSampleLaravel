<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */
use App\Model\Article;
use App\Model\Feedback;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
        'article_id' => function () {
            return Article::all()->random();
        },
        'reader' => $faker->name,
        'commment' => $faker->paragraph,
        'rating' => $faker->numberBetween(0, 5)
    ];
});
