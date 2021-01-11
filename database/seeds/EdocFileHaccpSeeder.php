<?php

use App\Imports\EdocFileHaccpImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class EdocFileHaccpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = database_path("seeds/edoc_file_haccp.xlsx");
        Excel::import(new EdocFileHaccpImport, $path);
    }
}
