<?php

use App\AttFile;
use App\HaccpMstFile;
use Illuminate\Database\Seeder;

class TestHaccpMstFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(HaccpMstFile::class, 1)->create()->each(function ($item) {
            factory(AttFile::class, 1)->create([
                'ATT_DTM' => $item->ATT_DTM
            ]);
        });
    }
}
