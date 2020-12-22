<?php

namespace App\Exports;

use App\ItemMst;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemMstExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public $itemNm, $itemId, $itemCd;

    public function __construct($itemNm, $itemId, $itemCd)
    {
        $this->itemNm = $itemNm;
        $this->itemId = $itemId;
        $this->itemCd = $itemCd;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $items = ItemMst::query();

        if (!empty($this->itemNm)) {
            $items = $items->where('ITEM_NM', 'LIKE', '%'.$this->itemNm.'%');
        }

        if (!empty($this->itemId)) {
            $items = $items->where('ITEM_ID', 'LIKE', '%'.$this->itemId.'%');
        }

        if (!empty($this->itemCd)) {
            $items = $items->where('ITEM_CD', $this->itemCd);
        }

        $items = $items->orderBy('ITEM_ID', 'asc');

        return $items->get();
    }

    public function map($itemMst): array
    {
        return [
            $itemMst->ITEM_ID,
            $itemMst->ITEM_NM,
            $itemMst->SPEC,
            $itemMst->UNIT,
            $itemMst->QTY1,
            $itemMst->QTY2,
            $itemMst->CONN_NO,
            $itemMst->CONN_QTY,
            $itemMst->IN_AMT,
            $itemMst->OUT_AMT,
            $itemMst->ITEM_CD,
            $itemMst->GRP1_CD,
            $itemMst->GRP2_CD,
            $itemMst->GRP3_CD,
            $itemMst->USE_YN,
            $itemMst->PROCESS_CD,
        ];
    }

    public function headings(): array
    {
        return [
            '품목ID',
            '품목명',
            '규격명',
            '단위',
            '당수량(분자)',
            '봉수량',
            '대표품목 환산수량',
            '연결품목 환산수량',
            '입고가',
            '출고가',
            '품목',
            '그룹1',
            '그룹2',
            '그룹3',
            '사용',
            '생산공정',
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
