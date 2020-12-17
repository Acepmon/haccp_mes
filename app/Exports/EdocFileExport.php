<?php

namespace App\Exports;

use App\EdocFile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EdocFileExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public $docNm, $typeCd, $useYn;

    public function __construct($docNm, $typeCd, $useYn)
    {
        $this->docNm = $docNm;
        $this->typeCd = $typeCd;
        $this->useYn = $useYn;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $items = EdocFile::query();

        if (!empty($this->docNm)) {
            $items = $items->where('doc_nm', 'LIKE', '%'.$this->docNm.'%');
        }

        if (!empty($this->typeCd)) {
            $items = $items->where('type_cd', $this->typeCd);
        }

        if (!empty($this->useYn)) {
            $items = $items->where('use_yn', $this->useYn);
        }

        $items = $items->orderBy('DOC_ID', 'asc');

        return $items->get();
    }

    public function map($edocFile): array
    {
        return [
            $edocFile->DOC_ID,
            $edocFile->DOC_NM,
            ($edocFile->type ? $edocFile->type->COMM2_NM : null),
            $edocFile->DOC_CONTENT,
            ($edocFile->period ? $edocFile->period->COMM2_NM : null),
            $edocFile->USE_YN,
            $edocFile->WORK_ID,
            $edocFile->APP_ID,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            '문서이름',
            '업무종류',
            '문서내용',
            '업무처리주기',
            '사용구분',
            '작업자',
            '승인자',
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
