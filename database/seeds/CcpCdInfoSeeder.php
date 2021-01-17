<?php

use App\Imports\CcpCdInfoImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CcpCdInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = database_path("seeds/ccp_cd_info.xlsx");
        Excel::import(new CcpCdInfoImport, $path);
    }
}
