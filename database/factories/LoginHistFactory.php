<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LoginHist;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(LoginHist::class, function (Faker $faker) {
    return [
        'LOGIN_DTM' => now()->subHours(rand(24, 168))->format('YmdHis'),
        'LOGOUT_DTM' => now()->subHours(rand(24, 168))->format('YmdHis'),
        'IP_ADDR' => $faker->ipv4,
    ];
});
