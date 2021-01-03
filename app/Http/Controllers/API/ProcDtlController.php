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
        $query = "SELECT SEQ_NO SEQ1, 0 SEQ2, PROC_NM, PROC_TIME, SEQ_NM, PROC_DTL FROM PROC_DTL WHERE ITEM_ID = '".$itemId."' UNION SELECT SEQ_NO, SUB_SEQ_NO, ' ', PROC_NM, SEQ_NM, PROC_DTL FROM PROC_DTL_SUB B WHERE ITEM_ID = '".$itemId."' ORDER BY 1, 2;";
        $items = DB::select($query);

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
