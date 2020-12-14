<?php

use App\AttFile;
use App\SecuDocMgmt;
use Illuminate\Database\Seeder;

class TestSecuDocMgmtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SecuDocMgmt::class, 1)->create()->each(function ($item) {
            factory(AttFile::class, 1)->create([
                'ATT_DTM' => $item->ATT_DTM
            ]);
        });
    }
}
