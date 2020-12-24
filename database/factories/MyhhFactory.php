<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Myhh;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Myhh::class, function (Faker $faker) {

    return [
        'MYHH_ID' => Str::limit($faker->name, 10, ''),
        'MYHH_NM' => Str::limit($faker->name, 20, ''),
        'USER_STS_YN' => 'Y',
        'REG_DTM' => now()->format('Ymdhis'),
    ];
});
