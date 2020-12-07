<?php

use App\Imports\CommCdImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CommCdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = database_path("seeds/common_code.xlsx");
        Excel::import(new CommCdImport, $path);
    }
}
