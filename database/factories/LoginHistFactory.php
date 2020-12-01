<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LoginHist;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(LoginHist::class, function (Faker $faker) {
    return [
        'login_dtm' => now()->subHours(rand(24, 168))->format('YmdHis'),
        'logout_dtm' => now()->subHours(rand(24, 168))->format('YmdHis'),
        'ip_addr' => $faker->ipv4,
    ];
});
