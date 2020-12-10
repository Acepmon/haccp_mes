<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CommCd;
use App\Worker;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Worker::class, function (Faker $faker) {
    $role = CommCd::where('COMM1_CD', 'A00')->whereNotIn('COMM2_CD', ['$$'])->inRandomOrder()->first();
    $work = CommCd::where('COMM1_CD', 'A05')->whereNotIn('COMM2_CD', ['$$'])->inRandomOrder()->first();

    return [
        'WORKER_NM' => Str::limit($faker->name, 60, ''),
        'TEL_NO' => '' . rand(11111111, 99999999),
        'WORK_CD' => $work->COMM2_CD,
        'HEALTH_CHK_DT' => now()->addDays(rand(1, 50))->format('Ymd'),
        'ROLE_CD' => $role->COMM2_CD,
        'REMARK' => $faker->text(100),
        'REG_ID' => 'admin',
        'REG_DTM' => now()->format('Ymdhis'),
    ];
});
