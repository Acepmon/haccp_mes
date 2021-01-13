<?php

namespace App\Imports;

use App\LotInfo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class LotInfoImport implements ToCollection
{
    public $updateCount = 0;
    public $insertCount = 0;

    public $cache;

    public function __construct()
    {
        $this->cache = collect();
    }

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $key => $row) 
            {
                //$row = trim($row)
                if ($key == 0 || $key == 1) {
                    continue;
                }

                if (strlen($row[0]) > 20 || trim($row[0]) == NULL) {
                    continue;
                }

                if (DB::table('LOT_INFO')->where('DT_NO', $row[0])->exists()) {
                    // Update
                    DB::table('LOT_INFO')->where('DT_NO', $row[0])->update([
                            'ITEM_ID' => $row[1],
                            'ITEM_NM' => $row[2],
                            'SPEC' => $row[3],
                            'UNIT' => $row[4],
                            'ORIGIN' => $row[5],
                            'LOT_NO' => $row[6],
                            'QTY' => $row[7],
                            'ACC_CD' => $row[8],
                            'IN_COST' => $row[9],
                            'OUT_COST' => $row[10],
                            'COMP_ID' => $row[11],
                            'COMP_NM' => $row[12],
                            'WH_CD' => $row[13],
                            'WH_NM' => $row[14],
                            'IN_WH_CD' => $row[15],
                            'IN_WH_NM' => $row[16],
                            'PROC_CD' => $row[17],
                            'PROC_NM' => $row[18],
                            'ITEM_DVN' => $row[19],
                            'BARCODE' => $row[20],
                            'WORK_ID' => $row[21],
                            'WORK_NM' => $row[22],
                            'REMARK' => $row[23],
                            'SAFE_QTY' => $row[24],
                            'ACC_NO' => $row[25],
                            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                            'REG_DTM' => now()->format('Ymdhis'),
                    ]);
                    $this->updateCount++;
                } else {
                    // Insert
                    if ($row[0] != null && $row[0] != '') {
                        DB::table('LOT_INFO')->insert([
                            'DT_NO' => $row[0],
                            'ITEM_ID' => $row[1],
                            'ITEM_NM' => $row[2],
                            'SPEC' => $row[3],
                            'UNIT' => $row[4],
                            'ORIGIN' => $row[5],
                            'LOT_NO' => $row[6],
                            'QTY' => $row[7],
                            'ACC_CD' => $row[8],
                            'IN_COST' => $row[9],
                            'OUT_COST' => $row[10],
                            'COMP_ID' => $row[11],
                            'COMP_NM' => $row[12],
                            'WH_CD' => $row[13],
                            'WH_NM' => $row[14],
                            'IN_WH_CD' => $row[15],
                            'IN_WH_NM' => $row[16],
                            'PROC_CD' => $row[17],
                            'PROC_NM' => $row[18],
                            'ITEM_DVN' => $row[19],
                            'BARCODE' => $row[20],
                            'WORK_ID' => $row[21],
                            'WORK_NM' => $row[22],
                            'REMARK' => $row[23],
                            'SAFE_QTY' => $row[24],
                            'ACC_NO' => $row[25],
                            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                            'REG_DTM' => now()->format('Ymdhis'),
                        ]);
                        $this->insertCount++;
                    }
                }
            }
        });

        session(['update_count' => $this->updateCount, 'insert_count' => $this->insertCount]);
    }
}
