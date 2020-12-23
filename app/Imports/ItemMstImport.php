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
                        'ITEM_CD' => $this->getCodeByName('B10', $row[10]),
                        'GRP1_CD' => $this->getCodeByName('B11', $row[11]),
                        'GRP2_CD' => $this->getCodeByName('B12', $row[12]),
                        'GRP3_CD' => $this->getCodeByName('B13', $row[13]),
                        'USE_YN' => $this->parseUseYn($row[14]),
                        'PROCESS_CD' => $this->getCodeByName('B14', $row[15]),
                    ]);
                }
            }
        });
    }

    private function parseCommNm($cd1, $cdnm)
    {
        $cd = CommCd::where('COMM1_CD', $cd1)->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_NM', $cdnm)->first();
        if ($cd) {
            dd($cd);
            return $cd->COMM2_CD;
        }
        return null;
    }

    private function getCodeByName($cd1, $cdnm)
    {
        if ($this->getCodeByNameExists()) {
            $item = DB::select('select get_codebyname(?, ?) as COMM2_CD', [$cd1, $cdnm]);

            if (is_array($item)) {
                $item = $item[0]->COMM2_CD;
            }

            $item = $item == 'Code Err' ? '' : $item;
        } else {
            $item = CommCd::where('COMM1_CD', $cd1)->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_NM', $cdnm)->first();
            $item = $item ? $item->COMM2_CD : '';
        }

        return $item;
    }

    private function getCodeByNameExists() {
        return DB::table('information_schema.ROUTINES')->where('ROUTINE_SCHEMA', config('database.connections.mysql.database'))->where('ROUTINE_NAME', 'get_codebyname')->exists();
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
