<?php

namespace App\Exports;

use App\DocMgmt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DocMgmtExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DocMgmt::orderBy('REG_DTM', 'desc')->get();
    }

    public function map($docMgmt): array
    {
        if ($docMgmt->att_file->count() > 0) {
            $att_nm = $docMgmt->att_file[0]->ATT_NM;
        } else {
            $att_nm = null;
        }

        return [
            $docMgmt->DOC_ID,
            $docMgmt->DOC_NM,
            $docMgmt->DOC_DESC,
            $att_nm,
            now()->parse($docMgmt->REG_DTM)->format('Y-m-d')
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            '문서이름',
            '문서종류',
            '설명(제품명)',
            '첨부문서',
            '등록일자',
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
