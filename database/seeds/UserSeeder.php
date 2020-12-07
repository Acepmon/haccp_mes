<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'USER_ID' => 'admin',
            'USER_PW' => Hash::make('password'),
            'USER_NM' => 'Administrator',
            'EMAIL' => env('ADMIN_EMAIL', null),
            'ROLE_CD' => 'AA',
            'USER_STS_YN' => 'Y',
        ]);
    }
}
