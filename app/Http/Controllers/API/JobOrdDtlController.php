<?php

namespace App\Http\Controllers\API;

use App\CommCd;
use App\Exports\JobOrdDtlExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemMstResource;
use App\JobOrd;
use App\JobOrdDtl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class JobOrdDtlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jobNo = $request->input('job_no');
        $itemId = $request->input('item_id');

        $nwItems1 = DB::table('JOB_ORD_DTL')
            ->select(DB::raw('SEQ_NO, "" SRC_CD, "전체공정" SRC_NM, SEQ_NM, PROC_NM, PROC_DTL, PROC_TIME, CCP_YN, "JOB_ORD_DTL" TABLE_NM, ITEM_ID, SRT_DTM, END_DTM, CCP_CD, CHK1_DTM, CHK_TEMP, CHK2_TIME, CHK2_TEMP'))
            ->where('JOB_NO', $jobNo)
            ->where('ITEM_ID', $itemId)
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

        $nwItems2 = DB::table('JOB_ORD_DTL_SUB')
            ->select(DB::raw('SEQ_NO, SRC_CD, "" SRC_NM, SEQ_NM, PROC_NM, PROC_DTL, PROC_TIME, CCP_YN, "JOB_ORD_DTL_SUB" TABLE_NM, ITEM_ID, SRT_DTM, END_DTM, CCP_CD, CHK1_DTM, CHK_TEMP, CHK2_TIME, CHK2_TEMP'))
            ->where('JOB_NO', $jobNo)
            ->where('ITEM_ID', $itemId)
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

        return response()->json([
            'data' => $nwItems1->merge($nwItems2)
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
        // 
    }
}
