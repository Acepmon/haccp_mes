<?php

namespace App\Http\Controllers\API;

use App\ProcDtl;
use App\ProcDtlSub;
use App\Http\Resources\ProcDtlResource;
use App\Http\Resources\ProcDtlSubResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemMstResource;
use App\ItemMst;
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
        if ($request->has('grid1')) {
            $items = ItemMst::query();

            $with = array_filter(explode(',', $request->input('with')));
            $limit = $request->input('limit', 15);

            if ($request->has('item_nm')) {
                $itemNm = $request->input('item_nm');
                $items = $items->where('ITEM_NM', 'LIKE', '%'.$itemNm.'%');
            }

            $items = $items->whereIn('ITEM_ID', function ($query) {
                $query->select('ITEM_ID')->from('PROC_DTL');
            });

            if ($limit == -1) {
                $items = $items->with($with)->get();
            } else {
                $items = $items->with($with)->paginate($limit);
            }

            return ItemMstResource::collection($items);
        } else {
            $itemId = $request->input('item_id');
            // // $query = "SELECT SEQ_NO SEQ1, 0 SEQ2, PROC_NM, PROC_TIME, SEQ_NM, PROC_DTL FROM PROC_DTL WHERE ITEM_ID = '".$itemId."' UNION SELECT SEQ_NO, SUB_SEQ_NO, ' ', PROC_NM, SEQ_NM, PROC_DTL FROM PROC_DTL_SUB B WHERE ITEM_ID = '".$itemId."' ORDER BY 1, 2;";
            // // $items = DB::select($query);
            // $query1 = DB::table('PROC_DTL')
            //     ->select(DB::raw('SEQ_NO SEQ1, "전체공정" SEQ2, PROC_NM, PROC_TIME, SEQ_NM, PROC_DTL, PROC_TIME, CCP_YN'))
            //     ->where('ITEM_ID', $itemId);

            // $query2 = DB::table(DB::raw('PROC_DTL_SUB B'))
            //     ->select(DB::raw('SEQ_NO, SRC_CD SEQ2, " ", PROC_NM, SEQ_NM, PROC_DTL, "" PROC_TIME, CCP_YN'))
            //     ->where('ITEM_ID', $itemId);

            // $items = $query1->union($query2)
            //     ->orderBy(DB::raw('1, 2'), 'ASC')
            //     ->get();

            $nwItems1 = DB::table('PROC_DTL')
                ->select(DB::raw('SEQ_NO, "전체공정" SRC_CD, SEQ_NM, PROC_NM, PROC_DTL, PROC_TIME, CCP_YN'))
                ->where('ITEM_ID', $itemId)
                ->get();
            $nwItems2 = DB::table('PROC_DTL_SUB')
                ->select(DB::raw('SEQ_NO, SRC_CD, SEQ_NM, PROC_NM, PROC_DTL, "" PROC_TIME, CCP_YN'))
                ->get();

            // $items2 = DB::table('BOM_CONFIG')
            //     ->select(DB::raw('(SELECT ITEM_NM FROM ITEM_MST WHERE ITEM_ID = ITEM2_ID) ITEM_NM, PROD_QTY, USE_QTY'))
            //     ->where('ITEM1_ID', $itemId)
            //     ->get();

            // if ($items2->count() > $items->count()) {
            //     $merged = $items2->map(function ($item, $index) use ($items) {
            //         $item1 = $items->get($index);
            //         $merged = array_merge((array) $item, (array) $item1);
            //         return $merged;
            //     });
            // } else {
            //     $merged = $items->map(function ($item, $index) use ($items2) {
            //         $item2 = $items2->get($index);
            //         $merged = array_merge((array) $item, (array) $item2);
            //         return $merged;
            //     });
            // }

            return response()->json([
                'data' => $nwItems1->merge($nwItems2)
            ]);
        }
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
