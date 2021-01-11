<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CcpEscData;
use App\CcpLimit;
use Faker\Generator as Faker;

$factory->define(CcpEscData::class, function (Faker $faker) {
    $deviceId = CcpLimit::inRandomOrder()->first()->DEVICE_ID;

    return [
        'DEVICE_ID' => $deviceId,
        'SRT_DTM' => now()->subHours(rand(1, 100))->format('Ymdhis'),
        'END_DTM' => now()->addHours(rand(1, 100))->format('Ymdhis'),
        'REASON' => $faker->text(300),
    ];
});
