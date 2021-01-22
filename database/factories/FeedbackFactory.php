<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use App\Feedback;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
        'customer_id' => Customer::get()->random()->id,
        'customer_phone_number' => $faker->unique()->e164PhoneNumber,
        'feedback_body' => $faker->paragraph()
    ];
});
