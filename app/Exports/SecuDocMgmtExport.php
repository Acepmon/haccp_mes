<?php

namespace App\Exports;

use App\SecuDocMgmt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SecuDocMgmtExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public $fromDt, $toDt;

    public function __construct($fromDt, $toDt)
    {
        $this->fromDt = $fromDt;
        $this->toDt = $toDt;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $items = SecuDocMgmt::query();

        if (!empty($this->fromDt)) {
            $items = $items->where('from_dt', now()->parse($this->fromDt)->format('Ymd'));
        }

        if (!empty($this->toDt)) {
            $items = $items->where('to_dt', now()->parse($this->toDt)->format('Ymd'));
        }

        $items = $items->orderBy('REG_DTM', 'desc');

        return $items->get();
    }

    public function map($secuDocMgmt): array
    {
        if ($secuDocMgmt->att_file->count() > 0) {
            $att_nm = $secuDocMgmt->att_file[0]->ATT_NM;
        } else {
            $att_nm = null;
        }

        return [
            $secuDocMgmt->DOC_ID,
            $secuDocMgmt->DOC_NM,
            now()->parse($secuDocMgmt->DOC_DT)->format('Y-m-d'),
            now()->parse($secuDocMgmt->FROM_DT)->format('Y-m-d'),
            now()->parse($secuDocMgmt->TO_DT)->format('Y-m-d'),
            $att_nm,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            '문서이름',
            '보고서작성일',
            '기간(From)',
            '기간(To)',
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
