<?php

namespace App\Exports;

use App\BomConfig;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BomConfigExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BomConfig::orderBy('ITEM1_ID', 'ASC')->with(['item1', 'item2'])->get();
    }

    public function map($bomConfig): array
    {
        return [
            $bomConfig->item1->ITEM_ID,
            $bomConfig->item1->ITEM_NM,
            $bomConfig->item1->SPEC,
            $bomConfig->item1->UNIT,
            $bomConfig->item1->QTY1,
            $bomConfig->item1->QTY2,
            $bomConfig->item1->CONN_NO,
            $bomConfig->item1->CONN_QTY,
            $bomConfig->item1->IN_AMT,
            $bomConfig->item1->OUT_AMT,
            $bomConfig->item1->item ? $bomConfig->item1->item->COMM2_NM : '',
            $bomConfig->item1->grp1 ? $bomConfig->item1->grp1->COMM2_NM : '',
            $bomConfig->item1->grp2 ? $bomConfig->item1->grp2->COMM2_NM : '',
            $bomConfig->item1->grp3 ? $bomConfig->item1->grp3->COMM2_NM : '',
            $this->parseUseYn($bomConfig->item1->USE_YN),
            $bomConfig->item1->process ? $bomConfig->item1->process->COMM2_NM : '',

            // Item2
            $bomConfig->ITEM2_ID,
            $bomConfig->item2->ITEM_NM,
            $bomConfig->BOM_VER,
            $this->parseUseYn($bomConfig->BOM_YN),
            $bomConfig->PROD_QTY,
            $bomConfig->USE_QTY,
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

            // Item2
            '소모품목코드',
            '소모품목명',
            'BOM 버젼',
            'BOM 사용유무',
            '생산수량',
            '소요량'
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
            $items = collect(DB::select('select get_codename(?, ?) as COMM2_NM', [$cd1, $cd2]));
        } else {
            $items = CommCd::select('COMM2_CD', 'COMM2_NM')->where('COMM1_CD', $cd1)->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_CD', $cd2)->get();
        }

        if ($items->count() > 0) {
            return implode(',', $items->pluck('COMM2_NM')->toArray());
        }

        return '';
    }

    private function getCodeNameExists() {
        return DB::table('information_schema.ROUTINES')->where('ROUTINE_SCHEMA', config('database.connections.mysql.database'))->where('ROUTINE_NAME', 'get_codename')->exists();
    }
}
