<?php

use App\CcpEscData;
use Illuminate\Database\Seeder;

class TestCcpEscDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CcpEscData::class, 50)->create();
    }
}
