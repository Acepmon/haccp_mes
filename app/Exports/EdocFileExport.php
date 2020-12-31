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
            $items = $items->where('DOC_NM', 'LIKE', '%'.$this->docNm.'%');
        }

        if (!empty($this->typeCd)) {
            $items = $items->where('TYPE_CD', $this->typeCd);
        }

        if (!empty($this->useYn)) {
            $items = $items->where('USE_YN', $this->useYn);
        }

        $items = $items->orderBy('DOC_ID', 'asc');

        return $items->get();
    }

    public function map($edocFile): array
    {
        $periods = [
            ['label' => "월", 'value' => 0],
            ['label' => "화", 'value' => 1],
            ['label' => "수", 'value' => 2],
            ['label' => "목", 'value' => 3],
            ['label' => "금", 'value' => 4],
            ['label' => "토", 'value' => 5],
            ['label' => "일", 'value' => 6],
        ];

        if (!empty($edocFile->PERIOD_DATA) || $edocFile->PERIOD_DATA == '0') {
            $period_data = explode(',', $edocFile->PERIOD_DATA);
            sort($period_data);

            $period_data_parsed = array_map(function ($period) use ($periods) {
                for ($i=0; $i < count($periods); $i++) {
                    if ($periods[$i]['value'] === intval($period)) {
                        return $periods[$i]['label'];
                    }
                }
                return '';
            }, $period_data);
        } else {
            $period_data_parsed = [];
        }

        return [
            $edocFile->DOC_ID,
            $edocFile->DOC_NM,
            ($edocFile->type ? $edocFile->type->COMM2_NM : null),
            $edocFile->DOC_CONTENT,
            ($edocFile->period ? $edocFile->period->COMM2_NM : null),
            implode(',', $period_data_parsed),
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
            '주기내용',
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
