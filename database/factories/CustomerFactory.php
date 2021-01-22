<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use App\PinCode;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'phone_number' => $faker->unique()->e164PhoneNumber,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'token' => Str::random(10),
        'pin_id' => PinCode::where('is_used', '=', '1')->get()->random()->id,
        'type' => 0,
        'user_photo' => "",
    ];
});
