<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CcpData;
use App\CommCd;
use Faker\Generator as Faker;

$factory->define(CcpData::class, function (Faker $faker) {
    $deviceId = CommCd::where('COMM1_CD', 'C00')->whereNotIn('COMM2_CD', ['$$'])->inRandomOrder()->value('COMM2_CD');

    return [
        'DEVICE_ID' => $deviceId,
        'DATA' => $faker->boolean ? rand(0, 150) : rand(-150, 0),
        'REG_DTM' => now()->format('Ymdhis'),
    ];
});
