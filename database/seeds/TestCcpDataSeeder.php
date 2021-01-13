<?php

use App\CcpData;
use App\CcpEscData;
use Illuminate\Database\Seeder;

class TestCcpDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CcpEscData::truncate();
        // for ($i=1; $i <= 100; $i++) { 
        //     factory(CcpData::class)->create([
        //         'DATA' => $i * rand(1, 5),
        //         'DEVICE_ID' => 'CONOVN'
        //     ]);

        //     usleep(10);
        // }
    }
}
