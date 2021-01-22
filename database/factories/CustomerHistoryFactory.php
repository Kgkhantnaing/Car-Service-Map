<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CustomerHistory;
use Faker\Generator as Faker;

$factory->define(CustomerHistory::class, function (Faker $faker) {
    return [
        'customer_id' => "110",
        'pin_id' => "5988416241808",
        'customer_phone_number' => "09789333573",
        'customer_name' => "Demo App",
        'is_claim' => 0
    ];
});
