<?php

namespace App\Imports;

use App\CustInfo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class CustInfoImport implements ToCollection
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

                if (DB::table('CUST_INFO')->where('COMP_ID', $row[0])->exists()) {
                    // Update
                    DB::table('CUST_INFO')->where('COMP_ID', $row[0])->update([
                        'COMP_NM' => $row[1],
                        'CEO_NM' => $row[2],
                        'MOB_NO' => $row[3],
                        'CUST_NM' => $row[4],
                        'CUST_NO' => $row[5],
                        'TEL_NO' => $row[6],
                        'FAX_NO' => $row[7],
                        'SRH_INFO' => $row[8],
                        'EMAIL' => $row[9],
                        'GRP_NM' => $row[10],
                        'ADDR' => $row[15],
                        'REMARK' => $row[16],
                        'USE_YN' => $this->parseUseYn($row[17]),
                    ]);
                    $this->updateCount++;
                } else {
                    // Insert
                    if ($row[0] != null && $row[0] != '') {
                        DB::table('CUST_INFO')->insert([
                            'COMP_ID' => $row[0],
                            'COMP_NM' => $row[1],
                            'CEO_NM' => $row[2],
                            'MOB_NO' => $row[3],
                            'CUST_NM' => $row[4],
                            'CUST_NO' => $row[5],
                            'TEL_NO' => $row[6],
                            'FAX_NO' => $row[7],
                            'SRH_INFO' => $row[8],
                            'EMAIL' => $row[9],
                            'GRP_NM' => $row[10],
                            'ADDR' => $row[15],
                            'REMARK' => $row[16],
                            'USE_YN' => $this->parseUseYn($row[17]),
                        ]);
                        $this->insertCount++;
                    }
                }
            }
        });

        session(['update_count' => $this->updateCount, 'insert_count' => $this->insertCount]);
    }

    private function parseUseYn($useYn)
    {
        if (strtoupper(trim($useYn)) == 'YES') {
            return 'Y';
        } else {
            return 'N';
        }

        return '';
    }
}
