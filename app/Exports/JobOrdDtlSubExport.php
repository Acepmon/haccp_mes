<?php

namespace App\Exports;

use App\CommCd;
use App\JobOrd;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

// class JobOrdDtlSubExport implements FromCollection, WithHeadings, WithStyles, WithMapping
class JobOrdDtlSubExport implements FromView
{
    public $jobNo, $itemId;

    public function __construct($jobNo, $itemId)
    {
        $this->jobNo = $jobNo;
        $this->itemId = $itemId;
    }

    public function view(): View
    {
        $jobOrd = JobOrd::query()
            ->where('JOB_NO', $this->jobNo)
            ->where('ITEM_ID', $this->itemId)
            ->with(['item'])
            ->first();

        $items = $this->collection();

        return view('exports.job_ord_dtl_sub', [
            'jobOrd' => $jobOrd,
            'items' => $items,
        ]);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $nwItems1 = DB::table('JOB_ORD_DTL')
            ->select(DB::raw('SEQ_NO, "" SRC_CD, "전체공정" SRC_NM, SEQ_NM, PROC_NM, PROC_DTL, PROC_TIME, CCP_YN, "JOB_ORD_DTL" TABLE_NM, ITEM_ID, SRT_DTM, END_DTM, CCP_CD, CHK1_DTM, CHK_TEMP, CHK2_TIME, CHK2_TEMP, "" EMP_NM, JOB_NO'))
            ->where('JOB_NO', $this->jobNo)
            ->where('ITEM_ID', $this->itemId)
            ->get();

        $lastSrcNm = null;
        foreach ($nwItems1 as $index => $item1) {
            if ($index == 0) {
                $lastSrcNm = $item1->SRC_NM;
                continue;
            }

            if ($lastSrcNm == $item1->SRC_NM) {
                $item1->SRC_NM = "";
            } else {
                $lastSrcNm = $item1->SRC_NM;
            }
        }

        $items = $nwItems1;

        $nwItems2 = DB::table('JOB_ORD_DTL_SUB')
            ->select(DB::raw('SEQ_NO, SRC_CD, "" SRC_NM, SEQ_NM, PROC_NM, PROC_DTL, PROC_TIME, CCP_YN, "JOB_ORD_DTL_SUB" TABLE_NM, ITEM_ID, SRT_DTM, END_DTM, CCP_CD, CHK1_DTM, CHK_TEMP, CHK2_TIME, CHK2_TEMP, "" EMP_NM, JOB_NO'))
            ->where('JOB_NO', $this->jobNo)
            ->where('ITEM_ID', $this->itemId)
            ->get();

        $lastSrcNm = null;
        foreach ($nwItems2 as $index => $item2) {
            $item2->SRC_NM = $item2->SRC_CD;

            if ($index == 0) {
                $lastSrcNm = $item2->SRC_NM;
                continue;
            }

            if ($lastSrcNm == $item2->SRC_NM) {
                $item2->SRC_NM = "";
            } else {
                $lastSrcNm = $item2->SRC_NM;
            }
        }

        foreach ($nwItems2 as $index => $item2) {
            if (!empty($item2->SRC_NM)) {
                if (CommCd::where('COMM1_CD', 'W20')->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_CD', $item2->SRC_NM)->exists()) {
                    $item2->SRC_NM = CommCd::where('COMM1_CD', 'W20')->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_CD', $item2->SRC_NM)->value('COMM2_NM');
                }
            }
        }

        $items = $nwItems1->merge($nwItems2);

        return $items;
    }

    public function map($jobOrdDtl): array
    {
        return [
            $jobOrdDtl->SRC_NM,
            $jobOrdDtl->SEQ_NM,
            $jobOrdDtl->PROC_NM,
            $jobOrdDtl->PROC_DTL,
            $jobOrdDtl->PROC_TIME,
            $jobOrdDtl->CCP_YN,
            $jobOrdDtl->SRT_DTM,
            $jobOrdDtl->END_DTM,
            $jobOrdDtl->CCP_CD,
            $jobOrdDtl->CHK1_DTM,
            $jobOrdDtl->CHK_TEMP,
            $jobOrdDtl->CHK2_TIME,
            $jobOrdDtl->CHK2_TEMP,
        ];
    }

    public function headings(): array
    {
        return [
            '공정구분',
            '공정순서',
            '공정명',
            '공정내용',
            '소요시간',
            'CCP 유무',
            '시작시간',
            '종료시간',
            'CCP 구분',
            '측정 시간',
            '측정 온도',
            '가열 시간',
            '품온',
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
