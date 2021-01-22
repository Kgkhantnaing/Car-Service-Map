<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SmsPin;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(SmsPin::class, function (Faker $faker) {
    return [
        'phone_number' => $faker->unique()->e164PhoneNumber,
        'sms_pin' => Str::random(10),
    ];
});
