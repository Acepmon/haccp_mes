<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LotInfoCostExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public $division;

    public function __construct($division)
    {
        $this->division = $division;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->division == 'in') {
            $items = DB::select(DB::raw("SELECT ITEM_ID, ITEM_NM, SUBSTRING(DT_NO, 1, 8) DATE, FORMAT(AVG(IN_COST), 0) COST FROM LOT_INFO WHERE IN_COST IS NOT NULL GROUP BY ITEM_ID, ITEM_NM, SUBSTRING(DT_NO, 1, 8) ORDER BY 1, 3"));
        } else if ($this->division == 'out') {
            $items = DB::select(DB::raw("SELECT ITEM_ID, ITEM_NM, SUBSTRING(DT_NO, 1, 8) DATE, FORMAT(AVG(IN_COST), 0) COST FROM LOT_INFO WHERE OUT_COST IS NOT NULL GROUP BY ITEM_ID, ITEM_NM, SUBSTRING(DT_NO, 1, 8) ORDER BY 1, 3"));
        }

        $lastItemId = null;
        $lastItemNm = null;

        foreach ($items as $index => $item) {
            if ($index == 0) {
                $lastItemId = $item->ITEM_ID;
                $lastItemNm = $item->ITEM_NM;

                continue;
            }

            if ($lastItemId == $item->ITEM_ID) {
                $item->ITEM_ID = null;
            } else {
                $lastItemId = $item->ITEM_ID;
            }

            if ($lastItemNm == $item->ITEM_NM) {
                $item->ITEM_NM = null;
            } else {
                $lastItemNm = $item->ITEM_NM;
            }
        }

        return collect($items);
    }

    public function map($item): array
    {
        return [
            $item->ITEM_ID,
            $item->ITEM_NM,
            $item->DATE,
            $item->COST,
        ];
    }

    public function headings(): array
    {
        return [
            '품목코드',
            '품목명',
            '일자',
            '단가'
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
