<?php

namespace App\Http\Controllers\API;

use App\ProcDtl;
use App\ProcDtlSub;
use App\Http\Resources\ProcDtlResource;
use App\Http\Resources\ProcDtlSubResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcDtlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // SELECT SEQ_NO SEQ1, 0 SEQ2, PROC_NM, PROC_TIME, SEQ_NM, PROC_DTL FROM PROC_DTL WHERE ITEM_ID = '' UNION SELECT SEQ_NO, SUB_SEQ_NO, " ", PROC_NM, SEQ_NM, PROC_DTL FROM PROC_DTL_SUB B WHERE ITEM_ID = '' ORDER BY 1, 2;
        $itemId = $request->input('item_id');
        $items = DB::table('PROC_DTL')
            ->join('PROC_DTL_SUB', 'PROC_DTL_SUB.ITEM_ID', '=', 'PROC_DTL.ITEM_ID')
            ->select(
                'PROC_DTL.PROC_NM as proc_dtl:proc_nm',
                'PROC_DTL.PROC_TIME as proc_dtl:proc_time',
                'PROC_DTL.SEQ_NM as proc_dtl:seq_nm',
                'PROC_DTL.PROC_DTL as proc_dtl:proc_dtl',
                'PROC_DTL_SUB.PROC_NM as proc_dtl_sub:proc_nm',
                'PROC_DTL_SUB.SEQ_NM as proc_dtl_sub:seq_nm',
                'PROC_DTL_SUB.PROC_DTL as proc_dtl_sub:proc_dtl'
            )
            ->where('PROC_DTL.ITEM_ID', $itemId)
            ->get();

        // $with = array_filter(explode(',', $request->input('with')));
        // $limit = $request->input('limit', 15);
        // $sort = $request->input('sort', 'REG_DTM');
        // $order = $request->input('order', 'DESC');

        // if ($request->has('item_id')) {
        //     $itemId = $request->input('item_id');
        //     $items = $items->where('ITEM_ID', $itemId);
        // }

        // // item_mst, proc_src, proc_dtl, proc_dtl_sub

        // if ($limit == -1) {
        //     $items = $items->with($with)->orderBy($sort, $order)->get();
        // } else {
        //     $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        // }

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
}
