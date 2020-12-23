<?php

namespace App\Exports;

use App\CommCd;
use App\ItemMst;
use Illuminate\Support\Facades\DB;
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
            $this->getCdNm('B10', $itemMst->ITEM_CD),
            $this->getCdNm('B11', $itemMst->GRP1_CD),
            $this->getCdNm('B12', $itemMst->GRP2_CD),
            $this->getCdNm('B13', $itemMst->GRP3_CD),
            $this->parseUseYn($itemMst->USE_YN),
            $this->getCdNm('B14', $itemMst->PROCESS_CD),
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

    private function parseUseYn($useYn)
    {
        if ($useYn == 'Y') {
            return 'YES';
        } else if ($useYn == 'N') {
            return 'NO';
        }

        return '';
    }

    private function getCdNm($cd1, $cd2)
    {
        if ($this->getCodeNameExists()) {
            $items = DB::select('select get_codename(?, ?) as comm2_nm', [$cd1, $cd2]);
        } else {
            $items = CommCd::select('COMM2_CD', 'comm2_nm')->where('COMM1_CD', $cd1)->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_CD', $cd2)->get();
        }
    }

    private function getCodeNameExists() {
        return DB::table('information_schema.ROUTINES')->where('ROUTINE_SCHEMA', config('database.connections.mysql.database'))->where('ROUTINE_NAME', 'get_codename')->exists();
    }
}
