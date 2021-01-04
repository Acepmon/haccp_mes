<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('COMP_INFO')->insert([
            'COMP_ID' => '681-86-00273',
            'COMP_NM' => '복을만드는사람들㈜농업회사법인',
            'CEO_NM' => '조은우',
            'TEL_NO' => '055-884-2252',
            'FAX_NO' => '055-884-2253',
            'URL' => 'https://1145.co.kr',
            'ZIP_CD' => '52322',
            'ADDR1' => '경상남도 하동군 하동읍',
            'ADDR2' => '섬진강대로 2498-11',
            'HACCP_ID' => null,
            'HACCP_ITEM' => '김밥, 타르트, 치즈 가공식품',
            'REG_ID' => 'admin',
            'REG_DTM' => now()->format('Ymdhis'),
        ]);
    }
}
