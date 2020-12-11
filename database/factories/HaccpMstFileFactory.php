<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HaccpMstFile;
use Faker\Generator as Faker;

$factory->define(HaccpMstFile::class, function (Faker $faker) {
    return [
        'REV_NO' => rand(1,10),
        'REV_DT' => now()->format('Ymd'),
        'ATT_DTM' => now()->subHours(1, 100)->format('Ymdhis'),
        'REV_CONTENT' => $faker->text(100),
        'REV_REASON' => $faker->text(100),
        'REG_ID' => 'admin',
        'REG_DTM' => now()->format('Ymdhis'),
    ];
});
