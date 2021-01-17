<?php

namespace App\Imports;

use App\CcpCdInfo;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CcpCdInfoImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            if ($key == 0) {
                continue;
            }

            if ($row[0] != null) {
                CcpCdInfo::create([
                    'CCP_CD' => $row[0],
                    'CCP_NM' => $row[1],
                    'TEMP_FR' => $row[2],
                    'TEMP_TO' => $row[3],
                    'BOIL_FR' => $row[4],
                    'BOIL_TO' => $row[5],
                    'CHK_TEMP' => $row[6],
                    'REMARK' => $row[7],
                    'REG_ID' => $row[8],
                    'REG_DTM' => $row[9],
                ]);
            }
        }
    }
}
