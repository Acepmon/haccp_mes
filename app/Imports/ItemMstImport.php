<?php

namespace App\Imports;

use App\CommCd;
use App\ItemMst;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class ItemMstImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $key => $row) 
            {
                if ($key == 0 || $key == 1) {
                    continue;
                }

                if (strlen($row[0]) > 20) {
                    continue;
                }

                if (DB::table('item_mst')->where('ITEM_ID', $row[0])->exists()) {
                    // Update
                    DB::table('item_mst')->where('ITEM_ID', $row[0])->update([
                        'ITEM_NM' => $row[1],
                        'SPEC' => $row[2],
                        'UNIT' => $row[3],
                        'QTY1' => doubleval($row[4]),
                        'QTY2' => doubleval($row[5]),
                        'CONN_NO' => doubleval($row[6]),
                        'CONN_QTY' => doubleval($row[7]),
                        'IN_AMT' => doubleval($row[8]),
                        'OUT_AMT' => doubleval($row[9]),
                        'ITEM_CD' => $this->parseCommNm('B10', $row[10]),
                        'GRP1_CD' => $this->parseCommNm('B11', $row[11]),
                        'GRP2_CD' => $this->parseCommNm('B12', $row[12]),
                        'GRP3_CD' => $this->parseCommNm('B13', $row[13]),
                        'USE_YN' => $this->parseUseYn($row[14]),
                        'PROCESS_CD' => $this->parseCommNm('B14', $row[15]),
                    ]);
                } else {
                    // Insert
                    DB::table('item_mst')->insert([
                        'ITEM_ID' => $row[0],
                        'ITEM_NM' => $row[1],
                        'SPEC' => $row[2],
                        'UNIT' => $row[3],
                        'QTY1' => doubleval($row[4]),
                        'QTY2' => doubleval($row[5]),
                        'CONN_NO' => doubleval($row[6]),
                        'CONN_QTY' => doubleval($row[7]),
                        'IN_AMT' => doubleval($row[8]),
                        'OUT_AMT' => doubleval($row[9]),
                        'ITEM_CD' => $this->parseCommNm('B10', $row[10]),
                        'GRP1_CD' => $this->parseCommNm('B11', $row[11]),
                        'GRP2_CD' => $this->parseCommNm('B12', $row[12]),
                        'GRP3_CD' => $this->parseCommNm('B13', $row[13]),
                        'USE_YN' => $this->parseUseYn($row[14]),
                        'PROCESS_CD' => $this->parseCommNm('B14', $row[15]),
                    ]);
                }
            }
        });
    }

    private function parseCommNm($cd1, $cd2_nm)
    {
        $cd = CommCd::where('COMM1_CD', $cd1)->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_NM', $cd2_nm)->first();
        if ($cd) {
            return $cd->COMM2_CD;
        }
        return null;
    }

    private function parseUseYn($useYn)
    {
        if ($useYn == 'YES') {
            return 'Y';
        } else if ($useYn == 'NO') {
            return 'N';
        }

        return '';
    }
}
