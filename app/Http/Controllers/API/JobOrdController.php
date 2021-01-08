<?php

namespace App\Http\Controllers\API;

use App\BomConfig;
use App\Exports\JobOrdExport;
use App\Exports\JobOrdExport2;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobOrdResource;
use App\Imports\JobOrdImport;
use App\JobOrd;
use App\JobOrdBom;
use App\JobOrdDtl;
use App\JobOrdDtlSub;
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
            $subdetails = DB::table('JOB_ORD_BOM')
                ->select('JOB_ORD_BOM.ITEM2_ID AS ITEM_ID', 'JOB_ORD_BOM.ITEM2_NM AS ITEM_NM', DB::raw('(JOB_ORD.ORD_QTY * JOB_ORD_BOM.USE_QTY / JOB_ORD_BOM.PROD_QTY) AS REQ'))
                ->join('JOB_ORD', 'JOB_ORD_BOM.ITEM_ID', '=', 'JOB_ORD.ITEM_ID')
                ->where('JOB_ORD_BOM.ITEM_ID', $jobOrd->ITEM_ID)
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

        // JobOrd::truncate();
        // JobOrdDtl::truncate();
        // JobOrdDtlSub::truncate();
        // JobOrdBom::truncate();

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
