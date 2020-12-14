<?php

use App\Imports\EdocFileImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class EdocFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = database_path("seeds/edoc_file.xlsx");
        Excel::import(new EdocFileImport, $path);
    }
}
