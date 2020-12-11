<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\AttFile;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;

$factory->define(AttFile::class, function (Faker $faker) {
    $name = $faker->file(storage_path('faker-files'), storage_path('app/files'), false);

    return [
        'ATT_DTM' => now()->subHours(rand(1, 100))->format('Ymdhis'),
        'ATT_SEQ' => 1,
        'ATT_NM' => $name,
        'ATT_PATH' => 'files/' . $name,
        'FILE_SZ' => filesize(storage_path('app/files/' . $name)),
        'RMK' => $faker->text(10),
    ];
});
