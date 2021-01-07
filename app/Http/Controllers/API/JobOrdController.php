<?php

namespace App\Http\Controllers\API;

use App\Exports\JobOrdExport;
use App\Exports\JobOrdExport2;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobOrdResource;
use App\Imports\JobOrdImport;
use App\JobOrd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class JobOrdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = JobOrd::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'DESC');

        if ($request->has('from') && !empty($request->input('from'))) {
            $from = $request->input('from');
            $items = $items->whereDate('JOB_DT', '>=', now()->parse($from)->format('YmdHis'));
        }

        if ($request->has('to') && !empty($request->input('to'))) {
            $to = $request->input('to');
            $items = $items->whereDate('JOB_DT', '<=', now()->parse($to)->format('YmdHis'));
        }

        if ($request->has('groupBy')) {
            $items = $items->whereIn('ITEM_ID', function ($query) {
                $query->select('ITEM1_ID')->from('BOM_CONFIG')->groupBy('ITEM1_ID');
            });
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return JobOrdResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function summaryDetails(Request $request)
    {
        $jobDt = $request->input('job_dt');
        $seqNo = $request->input('seq_no');

        $items = JobOrd::query()
            ->where('JOB_DT', $jobDt)
            ->where('SEQ_NO', intval($seqNo))
            ->get();

        $item = $items->first();

        return response()->json([
            'job_ord' => $jobDt . '-' . $seqNo,
            'summary_dt' => now()->parse($item->REG_DTM)->format('Y/m/d') . ' 오후 ' . now()->parse($item->REG_DTM)->format('H:i:s'),
            'summary' => $this->summary($items),
            'details' => $this->details($items),
            'details_dt' => now()->parse($item->REG_DTM)->format('Y/m/d') . ' 오후 ' . now()->parse($item->REG_DTM)->format('H:i:s'),
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function export(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        return Excel::download(new JobOrdExport($from, $to), 'JOB-ORD-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function summaryExport(Request $request)
    {
        $jobDt = $request->input('job_dt');
        $seqNo = $request->input('seq_no');

        return Excel::download(new JobOrdExport2($jobDt, $seqNo), 'JOB-ORD-SUMMARY-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        Excel::import(new JobOrdImport(), $request->file('file'));
        $upCnt = session()->get('update_count');
        $inCnt = session()->get('insert_count');

        return response()->json([
            'success' => true,
            'message' => $upCnt == 0 ? __('Successfully added') : __('Successfully updated')
        ]);
    }
}
