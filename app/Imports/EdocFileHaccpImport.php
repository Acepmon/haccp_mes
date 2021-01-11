<?php

namespace App\Imports;

use App\EdocFile;
use App\EdocFileHaccp;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EdocFileHaccpImport implements ToCollection
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

            if ($row[1] != null) {
                $edocFile = EdocFile::create([
                    'TYPE_CD' => $row[0],
                    'DOC_NM' => $row[1],
                    'DOC_DESC' => $row[2],
                    'DOC_CONTENT' => $row[3],
                    'DOC_APPDATA' => $row[4],
                    'PERIOD_CD' => $row[7],
                    'PERIOD_DATA' => $row[8],
                    'USE_YN' => $row[9],
                    'WORK_ID' => $row[10],
                    'APP_ID' => $row[11],
                    'UPD_DTM' => $row[12],
                ]);

                EdocFileHaccp::create([
                    'DOC_ID' => $edocFile->DOC_ID,
                    'APR_CD' => '10',
                    'APP_DATA' => $row[5],
                    'REMARK' => null,
                    'USE_YN' => 'Y',
                    'WORK_ID' => null,
                    'WORK_DTM' => null,
                    'APP_ID' => null,
                    'APP_DTM' => null,
                ]);

                EdocFileHaccp::create([
                    'DOC_ID' => $edocFile->DOC_ID,
                    'APR_CD' => '20',
                    'APP_DATA' => $row[6],
                    'REMARK' => null,
                    'USE_YN' => 'Y',
                    'WORK_ID' => null,
                    'WORK_DTM' => null,
                    'APP_ID' => null,
                    'APP_DTM' => null,
                ]);
            }
        }
    }
}
