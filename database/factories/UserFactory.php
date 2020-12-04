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
    $role = CommCd::where('comm1_cd', 'A10')->whereNotIn('comm2_cd', ['$$'])->inRandomOrder()->first();

    return [
        'user_id' => Str::limit($faker->unique()->userName, 15, ''),
        'user_pw' => Hash::make('password'),
        'user_nm' => Str::limit($faker->firstNameMale, 20, ''),
        'email' => $faker->email,
        'role_cd' => $role->comm2_cd,
        'user_sts_yn' => User::STATUS_ARRAY[array_rand(User::STATUS_ARRAY)],
        'reg_id' => Str::limit($faker->unique()->userName, 15, ''),
        'reg_dtm' => now()->subHours(rand(24, 168))->format('YmdHis'),
    ];
});
