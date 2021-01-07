<?php

namespace App\Exports;

use App\JobOrd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class JobOrdDtlExport implements FromView
{
    public $jobDt, $seqNo;

    public function __construct($jobDt, $seqNo)
    {
        $this->jobDt = $jobDt;
        $this->seqNo = $seqNo;
    }

    public function view(): View
    {
        $items = JobOrd::query()
            ->where('JOB_DT', $this->jobDt)
            ->where('SEQ_NO', intval($this->seqNo))
            ->get();

        $item = $items->first();
        $details = [
            'job_ord' => $this->jobDt . '-' . $this->seqNo,
            'summary_dt' => now()->parse($item->REG_DTM)->format('Y/m/d') . ' 오후 ' . now()->parse($item->REG_DTM)->format('H:i:s'),
            'summary' => $this->summary($items),
            'details' => $this->details($items),
            'details_dt' => now()->parse($item->REG_DTM)->format('Y/m/d') . ' 오후 ' . now()->parse($item->REG_DTM)->format('H:i:s'),
        ];

        return view('exports.job-ord-dtl', [
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
                'prod_qty' => number_format($jobOrd->PROD_QTY)
            ]);
        }

        return $summaries;
    }

    private function details($items)
    {
        $details = [];

        foreach ($items as $jobOrd) {
            $subdetails = DB::table('BOM_CONFIG')
                ->select('BOM_CONFIG.ITEM2_ID AS ITEM_ID', 'ITEM_MST.ITEM_NM AS ITEM_NM', DB::raw('(JOB_ORD.ORD_QTY * BOM_CONFIG.USE_QTY / BOM_CONFIG.PROD_QTY) AS REQ'))
                ->join('JOB_ORD', 'BOM_CONFIG.ITEM1_ID', '=', 'JOB_ORD.ITEM_ID')
                ->join('ITEM_MST', 'BOM_CONFIG.ITEM2_ID', '=', 'ITEM_MST.ITEM_ID')
                ->where('BOM_CONFIG.ITEM1_ID', $jobOrd->ITEM_ID)
                ->get();

            $sum = $subdetails->sum('REQ');

            array_push($details, [
                'reqSum' => number_format($sum),
                'ratio' => 100,
                'origin' => '',
                'item_id' => $jobOrd->ITEM_ID,
                'subdetails' => $subdetails->map(function ($subdetail) use ($sum) {
                    $ratio = 100 / $sum * intval($subdetail->REQ);
                    return [
                        'item_id' => $subdetail->ITEM_ID,
                        'item_nm' => $subdetail->ITEM_NM,
                        'req' => number_format(intval($subdetail->REQ)),
                        'ratio' => number_format((float) $ratio, 2, '.', ''),
                        'origin' => ''
                    ];
                })
            ]);
        }

        return $details;
    }
}
