<?php

namespace App\Imports;

use App\EdocFile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

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
                EdocFile::insert([
                    'DOC_ID' => $row[0],
                    'TYPE_CD' => $row[1],
                    'DOC_NM' => $row[2],
                    'DOC_DESC' => $row[3],
                    'DOC_CONTENT' => $row[4],
                    'DOC_APPDATA' => $row[5],
                    'PERIOD_CD' => $row[6],
                    'PERIOD_DATA' => $row[7],
                    'USE_YN' => $row[8],
                    'WORK_ID' => $row[9],
                    'APP_ID' => $row[10],
                    'UPD_DTM' => $row[11],
                ]);
            }
        }
    }
}
