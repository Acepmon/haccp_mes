<?php

namespace App\Exports;

use App\JobOrd;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JobOrdExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public $from, $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $items = JobOrd::query();

        if (!empty($this->from)) {
            $items = $items->whereDate('JOB_DT', '>=', now()->parse($this->from)->format('YmdHis'));
        }

        if (!empty($this->to)) {
            $items = $items->whereDate('JOB_DT', '<=', now()->parse($this->to)->format('YmdHis'));
        }

        $items = $items->orderBy('REG_DTM', 'DESC');

        return $items->with(['item'])->get();
    }

    public function map($jobOrd): array
    {
        return [
            $jobOrd->JOB_DT . '-' . $jobOrd->SEQ_NO,
            $jobOrd->ITEM_ID,
            $jobOrd->item->ITEM_NM,
            $jobOrd->ORD_QTY,
            $jobOrd->PROD_QTY,
            $jobOrd->ORD_NM,
            $jobOrd->FACT_CD,
        ];
    }

    public function headings(): array
    {
        return [
            '작업번호',
            '품목ID',
            '품목명',
            '지시수량',
            '생산수량',
            '담당자',
            '생산공장',
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
