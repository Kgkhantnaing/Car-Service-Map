<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PinCode;
use Faker\Generator as Faker;

$factory->define(PinCode::class, function (Faker $faker) {
    return [
        'pin' => $faker->unique()->numberBetween($min = 1000000000000, $max = 9999999999999), // 8567
        'is_used' => $faker->boolean($chanceOfGettingTrue = 0),
        'lucky_draw_amount' => $faker-> $faker->numberBetween($min = 1000, $max = 9000)
        
    ];
});
