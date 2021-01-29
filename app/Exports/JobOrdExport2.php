<?php

namespace App\Exports;

use App\JobOrd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class JobOrdExport2 implements FromView
{
    public $jobNo;

    public function __construct($jobNo)
    {
        $this->jobNo = $jobNo;
    }

    public function view(): View
    {
        $items = JobOrd::query()
            ->where('JOB_NO', $this->jobNo)
            ->with('item')
            ->get();

        $item = $items->first();
        $details = [
            'job_no' => $this->jobNo,
            'summary_dt' => now()->parse($item->REG_DTM)->format('Y/m/d') . ' 오후 ' . now()->parse($item->REG_DTM)->format('H:i:s'),
            'summary' => $this->summary($items),
            'details' => $this->details($items),
            'details_dt' => now()->parse($item->REG_DTM)->format('Y/m/d') . ' 오후 ' . now()->parse($item->REG_DTM)->format('H:i:s'),
        ];

        return view('exports.job_ord', [
            'details' => $details
        ]);
    }

    private function summary($items)
    {
        $summaries = [];

        foreach ($items as $jobOrd) {
            array_push($summaries, [
                'item_id' => $jobOrd->item->ITEM_ID,
                'item_nm' => $jobOrd->item->ITEM_NM,
                'fact_nm' => $jobOrd->FACT_CD,
                'prod_qty' => number_format($jobOrd->PROD_QTY),
                'ord_qty' => number_format($jobOrd->ORD_QTY)
            ]);
        }

        return $summaries;
    }

    private function details($items)
    {
        $details = [];

        foreach ($items as $jobOrd) {
            $subdetails = DB::select(DB::raw("select A.`JOB_NO`, A.`ITEM2_ID` as `ITEM_ID`, A.`ITEM2_NM` AS ITEM_NM, (B.ORD_QTY * A.USE_QTY / A.PROD_QTY) AS REQ 
from `JOB_ORD_BOM` A, `JOB_ORD` B where A.`ITEM_ID` = B.`ITEM_ID` 
and A.`JOB_NO` = B.`JOB_NO` and B.`JOB_NO` = '".$jobOrd->JOB_NO."' and B.ITEM_ID = '".$jobOrd->ITEM_ID."'"));
            $subdetails = collect($subdetails);

            $sum = $subdetails->sum('REQ');
            $mappedSubDetails = $subdetails->map(function ($subdetail) use ($sum) {
                $ratio = 100 / $sum * intval($subdetail->REQ);
                return [
                    'job_no' => $subdetail->JOB_NO,
                    'item_id' => $subdetail->ITEM_ID,
                    'item_nm' => $subdetail->ITEM_NM,
                    'req' => number_format(intval($subdetail->REQ)),
                    'ratio' => number_format((float) $ratio, 2, '.', ''),
                    'origin' => ''
                ];
            });

            array_push($details, [
                'reqSum' => number_format($sum),
                'ratio' => 100,
                'origin' => '',
                'item_id' => $jobOrd->ITEM_ID,
                'subdetails' => $mappedSubDetails
            ]);
        }

        return $details;
    }
}
