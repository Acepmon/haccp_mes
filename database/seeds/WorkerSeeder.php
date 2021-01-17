<?php

use App\Imports\WorkerImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = database_path("seeds/worker.xlsx");
        Excel::import(new WorkerImport, $path);
    }
}
