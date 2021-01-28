<?php

namespace App\Exports;

use App\Worker;
use App\CommCd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkerExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Worker::orderBy('EMP_ID', 'asc')->get();
    }

    public function map($worker): array
    {
        return [
            $worker->EMP_ID,
            $worker->EMP_NM,
            $worker->DUTY_CD,
            //DB::select("SELECT get_codename('W30', $worker->DUTY_CD)"),
            $worker->DEPT_CD,
            $worker->MOB_NO,
            $worker->IN_DT,
            $worker->OUT_DT,
            substr($worker->JUMIN_NO, 0, 8) . '******',
            $worker->BIRTH_DT,
            $worker->BANK_NM,
            $worker->ACCT_NO,
            $worker->ADDRESS,
            $worker->EMAIL,
            $worker->MAIN_JOB,
            $worker->HEALTH_CHK_DT,
            $worker->HACCP_DOC,
            $worker->ROLE_CD,
            $worker->HACCP_ROLE,
         ];
    }

    public function headings(): array
    {
        return [
            '사번',
            '이름',
            '직책',
            '부서',
            '전화번호',
            '입사일자',
            '퇴사일자',
            '주민번호',
            '생년월일',
            '은행명',
            '계좌번호',
            '주소',
            '이메일',
            '주요업무',
            '보건증갱신일자',
            'HACCP 문서관리',
            '정/부구분',
            'HACCP 담당역할',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
