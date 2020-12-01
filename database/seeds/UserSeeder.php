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
            'user_id' => 'admin',
            'user_pw' => Hash::make('password'),
            'user_nm' => 'Administrator',
            'email' => env('ADMIN_EMAIL', null),
            'role_cd' => 'AA',
            'user_sts_yn' => 'Y',
        ]);
    }
}
