<?php

namespace App\Imports;

use App\EdocFile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EdocFileImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            if ($key == 0) {
                continue;
            }

            if ($row[0] != null) {
                EdocFile::create([
                    'TYPE_CD' => $row[0],
                    'DOC_NM' => $row[1],
                    'DOC_DESC' => $row[2],
                    'DOC_HTML' => $row[3],
                    'APP_VIEW' => $row[4],
                    'APP_INPUT' => $row[5],
                    'APP_LIST' => $row[6],
                    'PERIOD_CD' => $row[7],
                    'PERIOD_DATA' => $row[8],
                    'USE_YN' => $row[9],
                    'WORK_ID' => $row[10],
                    'APP_ID' => $row[11],
                    'UPD_DTM' => $row[12],
                ]);
            }
        }
    }
}
