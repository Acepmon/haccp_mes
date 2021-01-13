<?php

namespace App\Exports;

use App\CustInfo;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustInfoExport implements FromCollection, WithHeadings, WithStyles, WithMapping
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
        $items = CustInfo::query();

        if (!empty($this->compNm)) {

            $items = $items->where('COMP_NM', 'LIKE', '%'.$this->compNm.'%')
                ->orWhere('CEO_NM', 'LIKE', '%'.$this->compNm.'%')
                ->orWhere('CUST_NM', 'LIKE', '%'.$this->compNm.'%');
 
        }

        return $items->get();
    }

    public function map($CustInfo): array
    {
        return [
            $CustInfo->COMP_ID,
            $CustInfo->COMP_NM,
            $CustInfo->CEO_NM,
            $CustInfo->MOB_NO,
            $CustInfo->CUST_NM,
            $CustInfo->CUST_NO,
            $CustInfo->TEL_NO,
            $CustInfo->FAX_NO,
            $CustInfo->SRH_INFO,
            $CustInfo->EMAIL,
            $CustInfo->GRP_NM,
            $CustInfo->ADDR,
            $CustInfo->REMARK,
            $CustInfo->USE_YN,
        ];
    }

    public function headings(): array
    {
        return [
            '거래처코드',
            '거래처명',
            '대표',
            '핸드폰번호',
            '담당1',
            '담당1 연락처',
            '전화번호',
            'Fax 번호',
            '검색창내용',
            'Email',
            '계층그룹명',
            '주소',
            '적요',
            '사용구분',
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
