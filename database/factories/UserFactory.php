<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CommCd;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $roles = CommCd::where('COMM1_CD', 'A10')->whereNotIn('COMM2_CD', ['$$'])->inRandomOrder()->take(3)->pluck('COMM2_CD');
    $appr = CommCd::where('COMM1_CD', 'A20')->whereNotIn('COMM2_CD', ['$$'])->inRandomOrder()->first();
    $job = CommCd::where('COMM1_CD', 'A30')->whereNotIn('COMM2_CD', ['$$'])->inRandomOrder()->first();

    return [
        'USER_ID' => Str::limit((string) Str::uuid(), 15, ''),
        'USER_PW' => Hash::make('password'),
        'USER_NM' => Str::limit($faker->firstNameMale, 20, ''),
        'EMAIL' => $faker->email,
        'ROLE_CD' => implode(',', $roles->toArray()),
        'APPR_CD' => $appr->COMM2_CD,
        'JOB_CD' => $job->COMM2_CD,
        'USER_STS_YN' => User::STATUS_ARRAY[array_rand(User::STATUS_ARRAY)],
        'REG_DTM' => now()->subHours(rand(24, 168))->format('YmdHis'),
    ];
});
