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
        DB::table('USER')->truncate();
        DB::table('USER')->insert([
            [
                'USER_ID' => 'admin',
                'USER_PW' => Hash::make('password'),
                'USER_NM' => 'Administrator',
                'EMAIL' => 'dtsogtbayar123@gmail.com',
                'ROLE_CD' => '10,20,30,40,50,60',
                'USER_STS_YN' => 'Y',
            ],
            [
                'USER_ID' => 'kenny',
                'USER_PW' => Hash::make('password'),
                'USER_NM' => 'Kwon Yoon',
                'EMAIL' => 'power747@gmail.com',
                'ROLE_CD' => '10,20,30,40,50,60',
                'USER_STS_YN' => 'Y',
            ]
        ]);
    }
}
