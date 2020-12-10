<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CommCd;
use App\CompInfo;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(CompInfo::class, function (Faker $faker) {
    $user = User::inRandomOrder()->first();
    $zip = CommCd::where('COMM1_CD', 'A30')->whereNotIn('COMM2_CD', ['$$'])->inRandomOrder()->first();

    return [
        'COMP_ID' => Str::limit((string) Str::uuid(), 20, ''),
        'COMP_NM' => Str::limit($faker->company, 60, ''),
        'CEO_NM' => Str::limit($faker->name, 60, ''),
        'TEL_NO' => rand(11111111, 99999999),
        'FAX_NO' => rand(11111111, 99999999),
        'URL' => Str::limit($faker->url, 30, ''),
        'ZIP_CD' => $zip->COMM2_CD,
        'ADDR1' => $faker->text(60),
        'ADDR2' => $faker->text(60),
        'HACCP_ID' => $user->user_id,
        'HACCP_ITEM' => $faker->text(100),
        'REG_ID' => 'admin',
        'REG_DTM' => now()->format('Ymdhis'),
    ];
});
