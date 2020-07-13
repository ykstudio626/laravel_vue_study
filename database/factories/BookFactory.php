<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'book_name' => $faker->realText(20 ,1),
        'author' => $faker->name,
        'price' => $faker->numberBetween(500 , 2000),
        'stocks' => $faker->numberBetween(1 ,100),
        'release_dt' => $faker->dateTime('now' , date_default_timezone_get())
    ];
});
