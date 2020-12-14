<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CommCd;
use App\DocMgmt;
use Faker\Generator as Faker;

$factory->define(DocMgmt::class, function (Faker $faker) {
    $type = CommCd::where('COMM1_CD', 'A35')->whereNotIn('COMM2_CD', ['$$'])->inRandomOrder()->first();

    return [
        'TYPE_CD' => $type->COMM2_CD,
        'DOC_NM' => $faker->text(20),
        'DOC_DESC' => $faker->text(150),
        'ATT_DTM' => now()->subHours(rand(1, 100))->format('Ymdhis'),
        'REG_ID' => 'admin',
        'REG_DTM' => now()->format('Ymdhis'),
    ];
});
