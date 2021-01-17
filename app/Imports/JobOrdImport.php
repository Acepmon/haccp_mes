<?php

namespace App\Imports;

use App\CommCd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

class JobOrdImport implements ToCollection
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
            foreach ($this->groupBySeqNo($rows) as $group) {
                foreach ($group as $row) {
                    $jobDt = $row[0];
                    $seqNo = $row[1];
                    $ordNm = $row[5];
                    $itemId = $row[10];
                    $ordQty = $row[14];
                    $factCd = $row[15];
                    $remark = $row[18];
    
                    $jobNo = $jobDt . '-' . $seqNo;
                    $bomVer = DB::table('BOM_CONFIG')->where('ITEM1_ID', $itemId)->value('BOM_VER');

                    // Step 0
                    $this->insertJobOrd([
                        ['JOB_NO', $jobNo],
                        ['ITEM_ID', $itemId]
                    ], [
                        'JOB_NO' => $jobNo,
                        'ITEM_ID' => $itemId,
                        'ORD_QTY' => $ordQty,
                        'PROD_QTY' => 0,
                        'ORD_NM' => $ordNm,
                        'BOM_VER' => $bomVer,
                        'FACT_CD' => $factCd,
                        'REMARK' => $remark
                    ]);

                    // Step 1
                    foreach (DB::table('PROC_DTL')->where('ITEM_ID', $itemId)->get() as $procDtl) {
                        $this->insertJobOrdDtl([
                            ['JOB_NO', $jobNo],
                            ['ITEM_ID', $itemId],
                            ['SEQ_NO', $procDtl->SEQ_NO],
                        ], [
                            'JOB_NO' => $jobNo,
                            'ITEM_ID' => $itemId,
                            'SEQ_NO' => $procDtl->SEQ_NO,
                            'SEQ_NM' => $procDtl->SEQ_NM,
                            'PROC_CD' => $procDtl->PROC_CD,
                            'PROC_NM' => $procDtl->PROC_NM,
                            'PROC_TIME' => $procDtl->PROC_TIME,
                            'PROC_DTL' => $procDtl->PROC_DTL,
                            'REMARK' => $remark,
                        ]);

                        // Step 2
                        foreach (DB::table('PROC_DTL_SUB')->where('ITEM_ID', $itemId)->where('SEQ_NO', $procDtl->SEQ_NO)->get() as $procDtlSub) {
                            $this->insertJobOrdDtlSub([
                                ['JOB_NO', $jobNo],
                                ['ITEM_ID', $itemId],
                                ['SRC_CD', $procDtlSub->SRC_CD],
                                ['SEQ_NO', $procDtlSub->SEQ_NO],
                            ], [
                                'JOB_NO' => $jobNo,
                                'ITEM_ID' => $itemId,
                                'SRC_CD' => $procDtlSub->SRC_CD,
                                'SEQ_NO' => $procDtlSub->SEQ_NO,
                                'SEQ_NM' => $procDtlSub->SEQ_NM,
                                'PROC_CD' => $procDtlSub->PROC_CD,
                                'PROC_NM' => $procDtlSub->PROC_NM,
                                'PROC_DTL' => $procDtlSub->PROC_DTL,
                                'REMARK' => $remark,
                            ]);
                        }
                    }

                    // Step 3
                    $bomConfigs = DB::table('BOM_CONFIG')
                        ->where('ITEM1_ID', $itemId)
                        ->where('BOM_VER', $bomVer)
                        ->join('ITEM_MST', 'ITEM_MST.ITEM_ID', '=', 'BOM_CONFIG.ITEM2_ID')
                        ->select('BOM_CONFIG.*', 'ITEM_MST.ITEM_NM AS ITEM2_NM')
                        ->get();

                    foreach ($bomConfigs as $bomConfig) {
                        $this->insertJobOrdBom([
                            ['JOB_NO', $jobNo],
                            ['ITEM_ID', $itemId],
                            ['ITEM2_ID', $bomConfig->ITEM2_ID],
                        ], [
                            'JOB_NO' => $jobNo,
                            'ITEM_ID' => $itemId,
                            'ITEM2_ID' => $bomConfig->ITEM2_ID,
                            'ITEM2_NM' => $bomConfig->ITEM2_NM,
                            'PROD_QTY' => $bomConfig->PROD_QTY,
                            'USE_QTY' => $bomConfig->USE_QTY,
                        ]);
                    }
                }
            }
        });

        session(['update_count' => $this->updateCount, 'insert_count' => $this->insertCount]);
    }

    private function groupBySeqNo(Collection $rows)
    {
        $groups = [];
        foreach ($rows as $index => $row) {
            if ($index == 0) {
                continue;
            }

            if (!empty($row[0]) && !empty($row[1])) {
                $key = $row[0] . '-' . $row[1];
                if (!array_key_exists($key, $groups)) {
                    $groups[$key] = [];
                }

                array_push($groups[$key], $row);
            }
        }
        return $groups;
    }

    private function insertJobOrd($keys = [], $attributes = [])
    {
        if (DB::table('JOB_ORD')->where($keys)->exists()) {
            DB::table('JOB_ORD')->where($keys)->update(array_merge([
                'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                'REG_DTM' => now()->format('Ymdhis'),
            ], $attributes));

            $this->updateCount++;
        } else {
            DB::table('JOB_ORD')->insert(array_merge([
                'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                'REG_DTM' => now()->format('Ymdhis'),
            ], $attributes));

            $this->insertCount++;
        }
    }

    private function insertJobOrdDtl($keys = [], $attributes = [])
    {
        if (DB::table('JOB_ORD_DTL')->where($keys)->exists()) {
            DB::table('JOB_ORD_DTL')->where($keys)->update($attributes);

            $this->updateCount++;
        } else {
            DB::table('JOB_ORD_DTL')->insert($attributes);

            $this->insertCount++;
        }
    }

    private function insertJobOrdDtlSub($keys = [], $attributes = [])
    {
        if (DB::table('JOB_ORD_DTL_SUB')->where($keys)->exists()) {
            DB::table('JOB_ORD_DTL_SUB')->where($keys)->update($attributes);

            $this->updateCount++;
        } else {
            DB::table('JOB_ORD_DTL_SUB')->insert( $attributes);

            $this->insertCount++;
        }
    }

    private function insertJobOrdBom($keys = [], $attributes = [])
    {
        if (DB::table('JOB_ORD_BOM')->where($keys)->exists()) {
            DB::table('JOB_ORD_BOM')->where($keys)->update($attributes);

            $this->updateCount++;
        } else {
            DB::table('JOB_ORD_BOM')->insert($attributes);

            $this->insertCount++;
        }
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
