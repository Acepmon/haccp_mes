<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CcpLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('CCP_LIMIT')->truncate();
        
        $srcCds = DB::table('COMM_CD')->where('COMM1_CD', 'W20')->whereNotIn('COMM2_CD', ['$$'])->get();
        $srcCds = $srcCds->pluck('COMM2_CD')->toArray();

        foreach ($this->premadeCcpLimits() as $ccpLimit) {
            foreach ($srcCds as $index => $srcCd) {
                DB::table('CCP_LIMIT')->insert(array_merge(
                    ['SRC_CD' => $srcCd, 'USE_YN' => $index == 0 ? 'Y' : 'N'],
                    $ccpLimit
                ));
            }
        }
    }

    private function premadeCcpLimits()
    {
        return collect([
            ['DEVICE_ID' => 'CONOVN', 'LMT_UP' => 180, 'LMT_DN' => 30],
            ['DEVICE_ID' => 'FREZFS', 'LMT_UP' => 30, 'LMT_DN' => -30],
            ['DEVICE_ID' => 'FREZMA', 'LMT_UP' => 20, 'LMT_DN' => -20],
            ['DEVICE_ID' => 'QUFRE1', 'LMT_UP' => 0, 'LMT_DN' => -50],
            ['DEVICE_ID' => 'QUFRE2', 'LMT_UP' => 10, 'LMT_DN' => -20],
        ]);
    }
}
