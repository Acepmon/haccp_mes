<?php

namespace App\Imports;

use App\ItemMst;
use App\ProcSrc;
use App\ProcDtl;
use App\ProcDtlSub;
use App\CommCd;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UnifiedProcImport implements ToCollection
{
    public $cache;

    public function __construct()
    {
        $this->cache = collect();
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            $groups = $this->groupRowsByItemID($rows);

            foreach ($groups as $itemId => $group) 
            {
                foreach ($group as $index => $row) {
                    $seqNo = $index + 1;

                    if (!empty(trim($row[0])) && !empty(trim($row[1]))) {
                        $this->insertProcSrc($itemId, trim($row[0]), trim($row[1]));
                    }

                    if (!empty(trim($row[2])) && !empty(trim($row[3])) && !empty(trim($row[4]))) {
                        $this->insertProcDtl($itemId, $seqNo, trim($row[2]), trim($row[3]), trim($row[4]), trim($row[5]));
                    }

                    $grp = $row->slice(6)->chunk(3);

                    foreach ($grp as $subIndex => $grp2) {
                        $subSeqNo = $subIndex + 1;
                        
                        $row2 = [];
                        foreach ($grp2 as $grp2Val) {
                            array_push($row2, $grp2Val);
                        }

                        $seqNm = array_key_exists(0, $row2) ? trim($row2[0]) : '';
                        $procNm = array_key_exists(1, $row2) ? trim($row2[1]) : '';
                        $procDtl = array_key_exists(2, $row2) ? trim($row2[2]) : '';

                        if (!empty($seqNm) && !empty($procNm)) {
                            $this->insertProcDtlSub($itemId, $seqNo, $subSeqNo, $seqNm, $procNm, $procDtl);
                        }
                    }

                }
            }
        });
    }

    private function groupRowsByItemID(Collection $rows)
    {
        $groups = [];
        $lastItemId = null;

        foreach ($rows as $index => $row) {
            // if ($index == 0) {
            //     continue;
            // }

            $firstCol = trim($row[0]);
            $thirdCol = trim($row[2]);

            if (strlen($row[0]) <= 0 && strlen($thirdCol) <= 0) {
                continue;
            }

            if (is_numeric($firstCol) || (strlen($firstCol) <= 0 && strlen($thirdCol) > 0)) {
                array_push($groups[$lastItemId], $row);
            } else {
                $lastItemId = $firstCol;
                $groups[$firstCol] = [];
            }
        }

        return $groups;
    }

    private function insertProcSrc($itemId, $seqNo, $srcNm)
    {
        DB::table('PROC_SRC')->insert([
            'ITEM_ID' => $itemId,
            'SEQ_NO' => $seqNo,
            'SRC_NM' => $srcNm,
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ]);
    }

    private function insertProcDtl($itemId, $seqNo, $seqNm, $procNm, $procTime, $procDtl)
    {
        DB::table('PROC_DTL')->insert([
            'ITEM_ID' => $itemId,
            'SEQ_NO' => $seqNo,
            'SEQ_NM' => $seqNm,
            'PROC_CD' => $this->getCodeByName('B80', $procNm),
            'PROC_NM' => $procNm,
            'PROC_TIME' => $procTime,
            'PROC_DTL' => $procDtl,
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ]);
    }

    private function insertProcDtlSub($itemId, $seqNo, $subSeqNo, $seqNm, $procNm, $procDtl)
    {
        DB::table('PROC_DTL_SUB')->insert([
            'ITEM_ID' => $itemId,
            'SEQ_NO' => $seqNo,
            'SUB_SEQ_NO' => $subSeqNo,
            'SEQ_NM' => $seqNm,
            'PROC_CD' => $this->getCodeByName('B80', $procNm),
            'PROC_NM' => $procNm,
            'PROC_DTL' => $procDtl,
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ]);
    }

    private function getCodeByName($cd1, $cdnm)
    {
        if ($this->cache->has($cd1 . ':' . $cdnm)) {
            return $this->cache->get($cd1 . ':' . $cdnm);
        }

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

        $this->cache->put($cd1 . ':' . $cdnm, $item);

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
