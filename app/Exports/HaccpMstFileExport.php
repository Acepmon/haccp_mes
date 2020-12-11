<?php

namespace App\Exports;

use App\HaccpMstFile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HaccpMstFileExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return HaccpMstFile::orderBy('REG_DTM', 'desc')->get();
    }

    public function map($haccp_mst_file): array
    {
        if ($haccp_mst_file->att_file->count() > 0) {
            $att_nm = $haccp_mst_file->att_file[0]->ATT_NM;
        } else {
            $att_nm = null;
        }

        return [
            $haccp_mst_file->REV_SEQ,
            $haccp_mst_file->REV_NO,
            now()->parse($haccp_mst_file->REV_DT)->format('Y-m-d'),
            $haccp_mst_file->REV_CONTENT,
            $haccp_mst_file->REV_REASON,
            $att_nm,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            '개정번호',
            '등록일자',
            '개정내용',
            '개정사유',
            '첨부화일',
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
