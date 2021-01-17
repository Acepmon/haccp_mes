<?php

namespace App\Imports;

use App\CommCd;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                if (Str::contains($itemId, '-headers')) {
                    continue;
                }

                foreach ($group as $index => $row) {
                    $seqNo = $index + 1;

                    if (!empty(trim($row[0])) && !empty(trim($row[1]))) {
                        $this->insertProcSrc($itemId, trim($row[0]), trim($row[1]));
                    }

                    if (!empty(trim($row[2])) && !empty(trim($row[3])) && !empty(trim($row[4]))) {
                        $this->insertProcDtl($itemId, $seqNo, trim($row[2]), trim($row[3]), trim($row[4]), trim($row[5]));
                    }

                    $grp = $row->slice(6)->chunk(3);

                    $headers = collect($groups[$itemId . '-headers']);
                    $headers = $headers->slice(6)->chunk(3);

                    foreach ($grp as $subIndex => $grp2) {
                        $subHeaders = $headers->get($subIndex);
                        
                        $row2 = [];
                        foreach ($grp2 as $grp2Val) {
                            array_push($row2, $grp2Val);
                        }

                        $subHeaders2 = [];
                        foreach ($subHeaders as $subHeaderVal) {
                            array_push($subHeaders2, $subHeaderVal);
                        }

                        $srcCd = array_key_exists(0, $subHeaders2) ? $subHeaders2[0] : 'etc';
                        // if (!DB::table('COMM_CD')->where('COMM1_CD', 'W20')->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_CD', $srcCd)->exists()) {
                        //     $srcCd = 'etc';
                        // }

                        $seqNm = array_key_exists(0, $row2) ? trim($row2[0]) : '';
                        $procNm = array_key_exists(1, $row2) ? trim($row2[1]) : '';
                        $procDtl = array_key_exists(2, $row2) ? trim($row2[2]) : '';

                        if (!empty($seqNm) && !empty($procNm)) {
                            $this->insertProcDtlSub($itemId, $srcCd, $seqNo, $seqNm, $procNm, $procDtl);
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
                $groups[$firstCol . '-headers'] = $row;
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
            'CCP_YN' => 'N',
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ]);
    }

    private function insertProcDtlSub($itemId, $srcCd, $seqNo, $seqNm, $procNm, $procDtl)
    {
        DB::table('PROC_DTL_SUB')->insert([
            'ITEM_ID' => $itemId,
            'SRC_CD' => $srcCd,
            'SEQ_NO' => $seqNo,
            'SEQ_NM' => $seqNm,
            'PROC_TIME' => 10,
            'PROC_CD' => $this->getCodeByName('B80', $procNm),
            'PROC_NM' => $procNm,
            'PROC_DTL' => $procDtl,
            'CCP_YN' => 'N',
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
