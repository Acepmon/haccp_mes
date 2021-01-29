<?php

namespace App\Http\Controllers\API;

use App\BomConfig;
use App\Exports\JobOrdExport;
use App\Exports\JobOrdExport2;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobOrdResource;
use App\Imports\JobOrdImport;
use App\JobOrd;
use App\JobOrdDtl;
use App\ProcDtl;
use App\ProcDtlSub;
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
            $items = $items->whereDate('REG_DTM', '>=', now()->parse($from)->format('YmdHis'));
        }

        if ($request->has('to') && !empty($request->input('to'))) {
            $to = $request->input('to');
            $items = $items->whereDate('REG_DTM', '<=', now()->parse($to)->format('YmdHis'));
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

    public function monitor(Request $request)
    {
        $items = DB::table('JOB_ORD')->select("JOB_NO", "ITEM_ID", "ITEM_NM", "ORD_QTY");

        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'JOB_NO');
        $order = $request->input('order', 'ASC');

        $items = $items->orderBy($sort, $order)->get();
        $items = $items->groupBy('JOB_NO');

        foreach ($items as $jobNo => $item) {
            $subItems = JobOrdDtl::where('JOB_NO', $jobNo)->select('PROC_NM', 'SRT_DTM', 'END_DTM')->get();
            foreach ($subItems as $key => $subItem) {
                $subItem->COLOR = "orange";

                if (!empty($subItem->SRT_DTM)) {
                    $subItem->SRT_DTM = now()->parse($subItem->SRT_DTM)->format('H:i');
                    $subItem->COLOR = "yellow";

                    if (!empty($subItem->END_DTM)) {
                        $subItem->COLOR = "blue";
                    }
                }

                if (!empty($subItem->END_DTM)) {
                    $subItem->END_DTM = now()->parse($subItem->END_DTM)->format('H:i');
                }
            }

            $item->first()->DTL = $subItems;
            $item->last()->DTL = $subItems;
            $item->first()->ORD_QTY = number_format($item->first()->ORD_QTY);
            $item->last()->ORD_QTY = number_format($item->last()->ORD_QTY);
        }

        return response()->json([
            'data' => $items
        ]);
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
        $jobNo = $request->input('job_no');

        $items = JobOrd::query()
            ->where('JOB_NO', $jobNo)
            ->with('item')
            ->get();

        $item = $items->first();

        return response()->json([
            'job_no' => $jobNo,
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
                'subdetails' => $mappedSubDetails,
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
        $jobNo = $request->input('job_no');

        return Excel::download(new JobOrdExport2($jobNo), 'JOB-ORD-SUMMARY-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        if (ProcDtl::count() == 0) {
            return response()->json([
                'success' => false,
                'message' => __('Process detail data not found.')
            ], 422);
        }

        if (ProcDtlSub::count() == 0) {
            return response()->json([
                'success' => false,
                'message' => __('Process detail sub data not found.')
            ], 422);
        }

        if (BomConfig::count() == 0) {
            return response()->json([
                'success' => false,
                'message' => __('BOM config data not found.')
            ], 422);
        }

        Excel::import(new JobOrdImport(), $request->file('file'));
        $upCnt = session()->get('update_count');
        $inCnt = session()->get('insert_count');

        return response()->json([
            'success' => true,
            'result' => [
                'update_count' => $upCnt,
                'insert_count' => $inCnt,
            ],
            'message' => $upCnt == 0 ? __('Successfully added') : __('Successfully updated')
        ]);
    }
}
