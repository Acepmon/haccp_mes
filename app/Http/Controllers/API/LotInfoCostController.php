<?php

namespace App\Http\Controllers\API;

use App\Exports\LotInfoCostExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LotInfoCostController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'division' => 'required|in:in,out'
        ]);
        
        $items = [];
        if ($request->input('division') == 'in') {
            $items = DB::select(DB::raw("SELECT ITEM_ID, ITEM_NM, SUBSTRING(DT_NO, 1, 8) DATE, FORMAT(AVG(IN_COST), 0) COST FROM LOT_INFO WHERE IN_COST IS NOT NULL GROUP BY ITEM_ID, ITEM_NM, SUBSTRING(DT_NO, 1, 8) ORDER BY 1, 3"));
        } else if ($request->input('division') == 'out') {
            $items = DB::select(DB::raw("SELECT ITEM_ID, ITEM_NM, SUBSTRING(DT_NO, 1, 8) DATE, FORMAT(AVG(IN_COST), 0) COST FROM LOT_INFO WHERE OUT_COST IS NOT NULL GROUP BY ITEM_ID, ITEM_NM, SUBSTRING(DT_NO, 1, 8) ORDER BY 1, 3"));
        }

        // $lastItemId = null;
        // $lastItemNm = null;

        // foreach ($items as $index => $item) {
        //     if ($index == 0) {
        //         $lastItemId = $item->ITEM_ID;
        //         $lastItemNm = $item->ITEM_NM;

        //         continue;
        //     }

        //     if ($lastItemId == $item->ITEM_ID) {
        //         $item->ITEM_ID = null;
        //     } else {
        //         $lastItemId = $item->ITEM_ID;
        //     }

        //     if ($lastItemNm == $item->ITEM_NM) {
        //         $item->ITEM_NM = null;
        //     } else {
        //         $lastItemNm = $item->ITEM_NM;
        //     }
        // }

        $items = collect($items)->groupBy('ITEM_ID');

        return response()->json([
            'data' => $items
        ]);
    }

    public function export(Request $request)
    {
        $request->validate([
            'division' => 'required'
        ]);

        return Excel::download(new LotInfoCostExport($request->input('division')), 'LOT-INFO-COST-' . now()->format('Y-m-d') . '.xlsx');
    }
}
