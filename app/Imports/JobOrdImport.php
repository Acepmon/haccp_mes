<?php

namespace App\Imports;

use App\BomConfig;
use App\CommCd;
use App\JobOrd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class JobOrdImport implements ToCollection
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
            $groups = $this->groupBySeqNo($rows);
            foreach ($groups as $key => $group) {
                $jobDt = $group[0][0];
                $seqNo = $group[0][1];
                $ordNm = $group[0][5];
                $itemId = $group[0][10];
                $item2Id = $group[1][10];
                $bomVer = BomConfig::where('ITEM1_ID', $itemId)->where('ITEM2_ID', $item2Id)->first();
                $bomVer = $bomVer != null ? $bomVer->BOM_VER : null;
                $ordQty = $group[0][14];
                $prodQty = $group[1][14];
                $factCd = $group[0][15];
                $remark = $group[0][18];

                $this->insertJobOrd([
                    'ITEM_ID' => $itemId,
                    'SEQ_NO' => $seqNo,
                ], [
                    'JOB_DT' => $jobDt,
                    'ORD_QTY' => $ordQty,
                    'PROD_QTY' => $prodQty,
                    'ORD_NM' => $ordNm,
                    'BOM_VER' => $bomVer,
                    'FACT_CD' => $factCd,
                    'REMARK' => $remark
                ]);
            }
        });
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
        DB::table('JOB_ORD')->updateOrInsert($keys, array_merge([
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ], $attributes));
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
