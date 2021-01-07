<?php

namespace App\Imports;

use App\BomConfig;
use App\CommCd;
use App\ItemMst;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
class BomConfigImport implements ToCollection
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
                if ($key == 0 || $key == 1) {
                    continue;
                }

                if (strlen($row[0]) > 20) {
                    continue;
                }

                if (DB::table('BOM_CONFIG')->where('ITEM1_ID', $row[0])->where('ITEM2_ID', $row[4])->where('BOM_VER', $row[3])->exists()) {
                    // Update
                    DB::table('BOM_CONFIG')->where('ITEM1_ID', $row[0])->where('ITEM2_ID', $row[4])->update([
                        'BOM_YN' => 'Y',
                        'PROD_QTY' => doubleval($row[6]),
                        'USE_QTY' => doubleval($row[7]),
                    ]);

                    if (!DB::table('ITEM_MST')->where('ITEM_ID', $row[4])->exists()) {
                        $row[4] = trim($row[4]);
                        if ($row[0] != null && $row[0] != '' && !empty($row[0])) {
                            DB::table('ITEM_MST')->insert([
                                'ITEM_ID' => $row[4],
                                'ITEM_NM' => $row[5],
                                'USE_YN' => 'Y',
                                'PROCESS_CD' => $this->getCodeByName('B14', $row[2]),
                            ]);
                            $this->insertCount++;
                        }
                    }

                    $this->updateCount++;
                } else {
                    // Insert
                    DB::table('BOM_CONFIG')->insert([
                        'ITEM1_ID' => $row[0],
                        'BOM_VER' => $row[3],
                        'ITEM2_ID' => $row[4],
                        'BOM_YN' => 'Y',
                        'PROD_QTY' => doubleval($row[6]),
                        'USE_QTY' => doubleval($row[7]),
                        'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                        'REG_DTM' => now()->format('Ymdhis'),
                    ]);

                    if (!DB::table('ITEM_MST')->where('ITEM_ID', $row[4])->exists()) {
                        $row[4] = trim($row[4]);
                        if ($row[0] != null && $row[0] != '' && !empty($row[0])) {
                            DB::table('ITEM_MST')->insert([
                                'ITEM_ID' => $row[4],
                                'ITEM_NM' => $row[5],
                                'USE_YN' => 'Y',
                                'PROCESS_CD' => $this->getCodeByName('B14', $row[2]),
                            ]);
                            $this->insertCount++;
                        }
                    }

                    $this->insertCount++;
                }
            }
        });

        session(['update_count' => $this->updateCount, 'insert_count' => $this->insertCount]);
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
