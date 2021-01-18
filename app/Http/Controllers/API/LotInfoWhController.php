<?php

namespace App\Http\Controllers\API;

use App\Exports\LotInfoWhExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\LotInfoWhResource;
//use App\Imports\LotInfoImport;
//use App\LotInfo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LotInfoWhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $qty = 0;
        // $items = collect(DB::select(DB::raw("SELECT wh_nm, item_id, item_nm, SUM(total) total
        //             FROM (SELECT wh_nm, item_id, item_nm,
        //             SUM(IF(acc_cd = '구매', qty, 0)) - SUM(IF(acc_cd = '생산불출', qty, 0)) -
        //             SUM(IF(acc_cd = '생산소모', qty, 0)) + SUM(IF(acc_cd = '생산입고', qty, 0)) -
        //             SUM(IF(acc_cd = '불량-폐기', qty, 0)) - SUM(IF(acc_cd = '자가사용', qty, 0)) +
        //             SUM(IF(acc_cd = '재고조정', qty, 0)) - SUM(IF(acc_cd = '창고이동', qty, 0)) -
        //             SUM(IF(acc_cd = '판매', qty, 0)) + SUM(IF(acc_cd = '견적', 0, 0)) total
        //             FROM LOT_INFO WHERE qty > ?
        //             GROUP BY wh_nm, item_id, item_nm
        //             UNION ALL
        //             SELECT in_wh_nm, item_id, item_nm,
        //             SUM(IF(acc_cd = '생산불출', qty, 0)) + SUM(IF(acc_cd = '창고이동', qty, 0)) total
        //             FROM LOT_INFO WHERE qty > ? AND in_wh_nm IS NOT NULL
        //             GROUP BY in_wh_nm, item_id, item_nm) WH_ITEM GROUP BY wh_nm, item_id, item_nm"), [$qty, $qty]));
        // $items = $items->where('acc_id', $);

       $items = DB::select(DB::raw("SELECT wh_nm, item_id, item_nm, acc_cd, SUM(qty) sub_tot
                    FROM LOT_INFO WHERE qty IS NOT NULL
                    GROUP BY wh_nm, item_id, item_nm, acc_cd
                    UNION 
                    SELECT in_wh_nm, item_id, item_nm, acc_cd,SUM(qty) sub_tot
                    FROM LOT_INFO WHERE qty IS NOT NULL AND IN_WH_NM IS NOT NULL
                    GROUP BY in_wh_nm, item_id, item_nm, acc_cd
                    UNION 
                    SELECT wh_nm, item_id, item_nm, '현재재고' acc_cd, SUM(total) total
                    FROM (SELECT wh_nm, item_id, item_nm,
                    SUM(IF(acc_cd = '구매', qty, 0)) - SUM(IF(acc_cd = '생산불출', qty, 0)) -
                    SUM(IF(acc_cd = '생산소모', qty, 0)) + SUM(IF(acc_cd = '생산입고', qty, 0)) -
                    SUM(IF(acc_cd = '불량-폐기', qty, 0)) - SUM(IF(acc_cd = '자가사용', qty, 0)) +
                    SUM(IF(acc_cd = '재고조정', qty, 0)) - SUM(IF(acc_cd = '창고이동', qty, 0)) -
                    SUM(IF(acc_cd = '판매', qty, 0)) + SUM(IF(acc_cd = '견적', 0, 0)) total
                    FROM LOT_INFO WHERE qty IS NOT NULL
                    GROUP BY wh_nm, item_id, item_nm
                    UNION 
                    SELECT in_wh_nm, item_id, item_nm,
                    SUM(IF(acc_cd = '창고이동', qty, 0)) total
                    FROM LOT_INFO WHERE qty IS NOT NULL AND in_wh_nm IS NOT NULL
                    GROUP BY in_wh_nm, item_id, item_nm) WH_ITEM GROUP BY wh_nm, item_id, item_nm ORDER BY 1,2,4"));
        
        return LotInfoWhResource::collection($items);
    }

    public function sync(Request $request)
    {
        // $request->validate([
        //     'sync' => 'required|array'
        // ]);

        // collect($request->input('sync'))->map(function ($item) {
        //     return [
        //         'COMP_ID' => $item['Lot_info:comp_id'],
        //         'COMP_NM' => $item['Lot_info:comp_nm'],
        //         'CEO_NM' => $item['Lot_info:ceo_nm'],
        //         'MOB_NO' => $item['Lot_info:mob_no'],
        //         'Lot_NM' => $item['Lot_info:Lot_nm'],
        //         'Lot_NO' => $item['Lot_info:Lot_no'],
        //         'TEL_NO' => $item['Lot_info:tel_no'],
        //         'FAX_NO' => $item['Lot_info:fax_no'],
        //         'SRH_INFO' => $item['Lot_info:srh_no'],
        //         'EMAIL' => $item['Lot_info:email'],
        //         'GRP_NM' => $item['Lot_info:grp_nm'],
        //         'ADDR' => $item['Lot_info:addr'],
        //         'REMARK' => $item['Lot_info:remark'],
        //         'USE_YN' => $item['Lot_info:use_yn']
        //     ];
        // });

        // return response()->json([
        //     'success' => true,
        //     'message' => __('Successfully saved'),
        // ]);
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
        $keyWord = 'stock'; //$request->input('comp_nm');

        return Excel::download(new LotInfoWhExport($keyWord), 'STOCK-INFO' . now()->format('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        //LotInfo::truncate();

        $result = Excel::import(new LotInfoImport(), $request->file('file'));
        $upCnt = session()->get('update_count');
        $inCnt = session()->get('insert_count');

        return response()->json([
            'success' => true,
            'result' => [
                'import' => $result,
                'update_count' => $upCnt,
                'insert_count' => $inCnt,
            ],
            'message' => 'Updated ' . $upCnt . ' records and inserted ' . $inCnt . ' records',
        ]);
    }
}
