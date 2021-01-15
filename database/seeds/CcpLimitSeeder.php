<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CcpLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('CCP_LIMIT')->truncate();
        DB::table('CCP_LIMIT')->insert([
            ['DEVICE_ID' => 'CONOVN', 'SRC_CD' => '10', 'USE_YN' => 'Y', 'LMT_UP' => 180, 'LMT_DN' => 30],
            ['DEVICE_ID' => 'FREZFS', 'SRC_CD' => '10', 'USE_YN' => 'Y', 'LMT_UP' => 30, 'LMT_DN' => -30],
            ['DEVICE_ID' => 'FREZMA', 'SRC_CD' => '10', 'USE_YN' => 'Y', 'LMT_UP' => 20, 'LMT_DN' => -20],
            ['DEVICE_ID' => 'QUFRE1', 'SRC_CD' => '10', 'USE_YN' => 'Y', 'LMT_UP' => 0, 'LMT_DN' => -50],
            ['DEVICE_ID' => 'QUFRE2', 'SRC_CD' => '10', 'USE_YN' => 'Y', 'LMT_UP' => 10, 'LMT_DN' => -20],
        ]);
    }
}
