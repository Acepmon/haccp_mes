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
use PDO;

class JobOrdImport implements ToCollection
{
    public $updateCount = 0;
    public $insertCount = 0;

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
                $itemId = $group[0][10];
                $item2Id = $group[1][10];

                foreach ($group as $index => $row) {
                    $bomVer = BomConfig::where('ITEM1_ID', $itemId)->where('ITEM2_ID', $item2Id)->first();
                    $bomVer = $bomVer != null ? $bomVer->BOM_VER : null;

                    $this->insertJobOrd([
                        'JOB_DT' => $row[0],
                        'SEQ_NO' => $row[1],
                        'ITEM_ID' => $row[10],
                    ], [
                        'ORD_QTY' => $row[14],
                        'PROD_QTY' => 0,
                        'ORD_NM' => $row[5],
                        'BOM_VER' => $bomVer,
                        'FACT_CD' => $row[15],
                        'REMARK' => $row[18]
                    ]);
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
            DB::table('JOB_ORD')->where($keys)->update(array_merge($keys, [
                'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                'REG_DTM' => now()->format('Ymdhis'),
            ], $attributes));

            $this->updateCount++;
        } else {
            DB::table('JOB_ORD')->where($keys)->insert(array_merge($keys, [
                'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                'REG_DTM' => now()->format('Ymdhis'),
            ], $attributes));

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
