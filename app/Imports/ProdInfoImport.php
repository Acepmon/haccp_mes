<?php

namespace App\Imports;

use App\ProdInfo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProdInfoImport implements ToCollection
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

                DB::table('PROD_INFO')->insert([
                    'ACC_NO' => $row[0],
                    'OUT_WH_NM' => $row[1],
                    'IN_WH_NM' => $row[2],
                    'ITEM_NM' => $row[3],
                    'ITEM_ID' => $row[4],
                    'SPEC' => $row[5],
                    'QTY' => $row[6],
                    'LOT_NO' => $row[7],
                    'REMARK' => $row[8],
                    'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                    'REG_DTM' => now()->format('Ymdhis'),
                ]);
                $this->insertCount++;
            }
        });
        
        session(['update_count' => $this->updateCount, 'insert_count' => $this->insertCount]);
    }
}
