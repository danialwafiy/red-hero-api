<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Donation;
use Faker\Generator as Faker;

$factory->define(Donation::class, function (Faker $faker) {
    return [
        'hospital' => $faker->catchPhrase,
        'donor_id' => rand(1,3),
        'date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'donor_name' => $faker->name,
        'donor_donated_litre' => rand(200,300)
    ];
});