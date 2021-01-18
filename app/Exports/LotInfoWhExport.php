<?php

namespace App\Exports;

//use App\LotInfo;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LotInfoWhExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public $compNm;

    public function __construct($compNm)
    {
        $this->compNm = $compNm;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // $items = items::query();

        // if (!empty($this->compNm)) {

        //     $items = $items->where('COMP_NM', 'LIKE', '%'.$this->compNm.'%')
        //         ->orWhere('CEO_NM', 'LIKE', '%'.$this->compNm.'%')
        //         ->orWhere('CUST_NM', 'LIKE', '%'.$this->compNm.'%');
 
        // }

        // return $items->get();

        $items = collect(DB::select(DB::raw("SELECT wh_nm, item_id, item_nm, acc_cd, SUM(qty) sub_tot
                    FROM LOT_INFO WHERE qty IS NOT NULL
                    GROUP BY wh_nm, item_id, item_nm, acc_cd
                    UNION 
                    SELECT in_wh_nm, item_id, item_nm, acc_cd,SUM(qty) sub_tot
                    FROM LOT_INFO WHERE qty IS NOT NULL AND IN_WH_NM IS NOT NULL
                    GROUP BY in_wh_nm, item_id, item_nm, acc_cd
                    UNION 
                    SELECT wh_nm, item_id, item_nm, '현재재고' acc_cd, SUM(total) total
                    FROM (SELECT wh_nm, item_id, item_nm,
                    SUM(IF(acc_cd = '구매', qty, 0)) - SUM(IF(acc_cd = '생산불출', qty, 0)) -
                    SUM(IF(acc_cd = '생산소모', qty, 0)) + SUM(IF(acc_cd = '생산입고', qty, 0)) -
                    SUM(IF(acc_cd = '불량-폐기', qty, 0)) - SUM(IF(acc_cd = '자가사용', qty, 0)) +
                    SUM(IF(acc_cd = '재고조정', qty, 0)) - SUM(IF(acc_cd = '창고이동', qty, 0)) -
                    SUM(IF(acc_cd = '판매', qty, 0)) + SUM(IF(acc_cd = '견적', 0, 0)) total
                    FROM LOT_INFO WHERE qty IS NOT NULL
                    GROUP BY wh_nm, item_id, item_nm
                    UNION 
                    SELECT in_wh_nm, item_id, item_nm,
                    SUM(IF(acc_cd = '창고이동', qty, 0)) total
                    FROM LOT_INFO WHERE qty IS NOT NULL AND in_wh_nm IS NOT NULL
                    GROUP BY in_wh_nm, item_id, item_nm) WH_ITEM GROUP BY wh_nm, item_id, item_nm ORDER BY 1,2,4")));
        
        return $items;

    }

    public function map($items): array
    {
        return [
            $items->wh_nm,
            $items->item_id,
            $items->item_nm,
            $items->acc_cd,
            $items->sub_tot,
        ];
    }

    public function headings(): array
    {
        return [
            '창고명',
            '품목코드',
            '품목명',
            '전표구분',
            '재고수량',
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
