<?php

namespace App\Exports;

use App\Worker;
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
        return Worker::orderBy('REG_DTM', 'desc')->get();
    }

    public function map($worker): array
    {
        return [
            $worker->WORKER_ID,
            $worker->WORKER_NM,
            $worker->TEL_NO,
            ($worker->work ? $worker->work->COMM2_NM : null),
            $worker->REMARK,
            now()->parse($worker->HEALTH_CHK_DT)->format('Y-m-d'),
            ($worker->role ? $worker->role->COMM2_NM : null),
            now()->parse($worker->REG_DTM)->format('Y-m-d')
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            '이름',
            '휴대폰번호',
            '업무구분',
            '업무내용',
            '보건증갱신일자',
            '정/부',
            '등록일시',
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
