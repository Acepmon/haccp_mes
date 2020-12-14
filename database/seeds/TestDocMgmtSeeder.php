<?php

use App\AttFile;
use App\DocMgmt;
use Illuminate\Database\Seeder;

class TestDocMgmtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DocMgmt::class, 1)->create()->each(function ($item) {
            factory(AttFile::class, 1)->create([
                'ATT_DTM' => $item->ATT_DTM
            ]);
        });
    }
}
