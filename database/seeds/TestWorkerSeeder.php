<?php

use App\Worker;
use Illuminate\Database\Seeder;

class TestWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Worker::class, rand(10, 50))->create();
    }
}
