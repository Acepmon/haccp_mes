<?php

use App\CompInfo;
use Illuminate\Database\Seeder;

class TestCompInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CompInfo::class)->create();
    }
}
