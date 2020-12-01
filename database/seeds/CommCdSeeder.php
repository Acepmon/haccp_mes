<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommCdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comm_cd')->insert([
            ['comm1_cd' => 'A10', 'comm2_cd' => '$$', 'comm2_nm' => 'User Role', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'A10', 'comm2_cd' => 'AA', 'comm2_nm' => 'System Admin', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'A10', 'comm2_cd' => 'HA', 'comm2_nm' => 'HACCP Manager', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'A10', 'comm2_cd' => 'PU', 'comm2_nm' => 'Purchase', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'A10', 'comm2_cd' => 'ST', 'comm2_nm' => 'Stock', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'A10', 'comm2_cd' => 'PR', 'comm2_nm' => 'Production', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'A10', 'comm2_cd' => 'SA', 'comm2_nm' => 'Sales', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'B10', 'comm2_cd' => '$$', 'comm2_nm' => 'Approval code', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'B10', 'comm2_cd' => '10', 'comm2_nm' => 'Wait for Approval', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'B10', 'comm2_cd' => '20', 'comm2_nm' => 'Approval', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'B10', 'comm2_cd' => '30', 'comm2_nm' => 'Refuse to approval', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => '$$', 'comm2_nm' => 'Country Code', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'NG', 'comm2_nm' => 'NIGERIA', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'AQ', 'comm2_nm' => 'ANTARCTICA', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'NI', 'comm2_nm' => 'NICARAGUA', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'KR', 'comm2_nm' => 'KOREA, REPUBLIC OF', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'DK', 'comm2_nm' => 'DENMARK', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'DM', 'comm2_nm' => 'DOMINICA', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'DE', 'comm2_nm' => 'GERMANY', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'MV', 'comm2_nm' => 'MALDIVES', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'MT', 'comm2_nm' => 'MALTA', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'MN', 'comm2_nm' => 'MONGOLIA', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
            ['comm1_cd' => 'Z10', 'comm2_cd' => 'US', 'comm2_nm' => 'UNITED STATES', 'reg_id' => 'admin', 'reg_dtm' => '20201201153327'],
        ]);
    }
}
