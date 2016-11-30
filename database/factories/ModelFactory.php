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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'bidder_number' => $faker->numberBetween(500100, 600200),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Bid::class, function (Faker\Generator $faker) {
    return [
        'user_id'   => $faker->numberBetween(1, 5),
        'name'      => $faker->firstName . ' ' . $faker->lastName,
        'datetime'  => $faker->dateTimeBetween('-5 days', '+5 days')->format('m/d/Y, h:i'),
        'location'  => $faker->streetAddress,
        'description' => $faker->sentence(),
        'cur_bid' => $faker->randomFloat(1,0,1000),
        'max_bid' => $faker->randomFloat(1,0,1000),
        'won'     => $faker->numberBetween(0,1),
        'url'     => $faker->url
    ];
});
