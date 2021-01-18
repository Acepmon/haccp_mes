<?php

namespace App\Imports;

use App\Worker;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class WorkerImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            if ($key == 0) {
                continue;
            }

            if ($row[0] != null) {
                Worker::create([
                    'EMP_ID' => $row[0],
                    'EMP_NM' => $row[1],
                    'DUTY_CD' => $row[2],
                    'MOB_NO' => $row[3],
                    'PASS_NO' => $row[4],
                    'DEPT_CD' => $row[5],
                    'IN_DT' => $row[6],
                    'OUT_DT' => $row[7],
                    'JUMIN_NO' => $row[8],
                    'BIRTH_DT' => $row[9],
                    'BANK_NM' => $row[10],
                    'ACCT_NO' => $row[11],
                    'ADDRESS' => $row[12],
                    'EMAIL' => $row[13],
                    'MAIN_JOB' => $row[14],
                    'HEALTH_CHK_DT' => $row[15],
                    'HACCP_DOC' => $row[16],
                    'ROLE_CD' => $row[17],
                    'HACCP_ROLE' => $row[18],
                    'REG_ID' => $row[19],
                    'REG_DTM' => $row[20],
                ]);
            }
        }
    }
}
