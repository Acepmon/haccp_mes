<?php

namespace App\Exports;

use App\EdocFile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EdocFileExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return EdocFile::orderBy('DOC_ID', 'asc')->get();
    }

    public function map($edocFile): array
    {
        return [
            $edocFile->DOC_ID,
            $edocFile->DOC_NM,
            $edocFile->type->COMM2_NM,
            $edocFile->DOC_CONTENT,
            $edocFile->period->COMM2_NM,
            $edocFile->USE_YN,
            $edocFile->WORK_ID,
            $edocFile->APP_ID,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            '문서이름',
            '업무종류',
            '문서내용',
            '업무처리주기',
            '사용구분',
            '작업자',
            '승인자',
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
