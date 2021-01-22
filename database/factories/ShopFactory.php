<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Shop;
use Faker\Generator as Faker;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'image_url' => $faker->imageUrl(400, 400),
        'address' => $faker->address(),
        'latitude' => $faker->latitude(),
        'longitude' => $faker->longitude(),
        'description' => $faker->paragraph(),
        'phone_no' => $faker->tollFreePhoneNumber(),
        'city' => $faker->city(),
        'remark' => $faker->paragraph(),
        'category_id' => Category::get('id')->random()
    ];
});
