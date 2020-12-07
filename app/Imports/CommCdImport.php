<?php

namespace App\Imports;

use App\CommCd;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class CommCdImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            if ($key == 0) {
                continue;
            }

            CommCd::insert([
                'COMM1_CD' => $row[0],
                'COMM2_CD' => $row[1],
                'COMM2_NM' => $row[2],
                'REG_ID' => $row[3],
                'REG_DTM' => $row[4],
            ]);
        }
    }
}
