<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SecuDocMgmt;
use Faker\Generator as Faker;

$factory->define(SecuDocMgmt::class, function (Faker $faker) {
    return [
        'DOC_NM' => $faker->text(100),
        'DOC_DT' => now()->format('Ymd'),
        'ATT_DTM' => now()->subHours(rand(1, 100))->format('Ymdhis'),
        'FROM_DT' => now()->subDays(rand(20, 50))->format('Ymd'),
        'TO_DT' => now()->subDays(rand(1, 20))->format('Ymd'),
        'REG_ID' => 'admin',
        'REG_DTM' => now()->format('Ymdhis'),
    ];
});
