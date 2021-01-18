<?php

namespace App\Exports;

use App\JobOrdDtlWork;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class JobOrdDtlExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public $jobNo, $itemId;

    public function __construct($jobNo, $itemId)
    {
        $this->jobNo = $jobNo;
        $this->itemId = $itemId;
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

        foreach ($nwItems1 as $index => $item1) {
            $jobOrdDtlWorkers = JobOrdDtlWork::where('JOB_NO', $this->jobNo)->where('ITEM_ID', $this->itemId)->where('SEQ_NO', $item1->SEQ_NO)->with(['worker'])->get();
            $empNms = [];
            foreach ($jobOrdDtlWorkers as $key => $jobOrdDtlWorker) {
                array_push($empNms, $jobOrdDtlWorker->worker->EMP_NM);
            }
            $item1->EMP_NM = implode(',', $empNms);
        }

        $items = $nwItems1;

        return $items;
    }

    public function map($jobOrdDtl): array
    {
        return [
            $jobOrdDtl->SEQ_NM,
            $jobOrdDtl->PROC_NM,
            $jobOrdDtl->PROC_DTL,
            $jobOrdDtl->PROC_TIME,
            $jobOrdDtl->CCP_YN,
            $jobOrdDtl->SRT_DTM,
            $jobOrdDtl->END_DTM,
            $jobOrdDtl->EMP_NM,
        ];
    }

    public function headings(): array
    {
        return [
            '공정순서',
            '공정명',
            '공정내용',
            '소요시간',
            'CCP 유무',
            '시작시간',
            '종료시간',
            '작업자',
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
