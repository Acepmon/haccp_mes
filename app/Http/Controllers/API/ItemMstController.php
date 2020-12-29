<?php

namespace App\Http\Controllers\API;

use App\Exports\ItemMstExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemMstResource;
use App\Imports\ItemMstImport;
use App\ItemMst;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ItemMstController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = ItemMst::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'ITEM_ID');
        $order = $request->input('order', 'ASC');

        if ($request->has('item_nm')) {
            $itemNm = $request->input('item_nm');
            $items = $items->where('ITEM_NM', 'LIKE', '%'.$itemNm.'%');
        }

        if ($request->has('item_id')) {
            $itemId = $request->input('item_id');
            $items = $items->where('ITEM_ID', 'LIKE', '%'.$itemId.'%');
        }

        if ($request->has('item_cd') && !empty($request->input('item_cd'))) {
            $itemCd = $request->input('item_cd');
            $items = $items->where('ITEM_CD', $itemCd);
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return ItemMstResource::collection($items);
    }

    public function sync(Request $request)
    {
        $request->validate([
            'sync' => 'required|array'
        ]);

        collect($request->input('sync'))->map(function ($item) {
            return [
                'ITEM_ID' => $item['item_mst:item_id'],
                'UNIT1_NM' => $item['item_mst:unit1_nm'],
                'UNIT1_QTY' => $item['item_mst:unit1_qty'],
                'UNIT2_NM' => $item['item_mst:unit2_nm'],
                'UNIT2_QTY' => $item['item_mst:unit2_qty'],
                'UNIT3_NM' => $item['item_mst:unit3_nm'],
                'UNIT3_QTY' => $item['item_mst:unit3_qty'],
            ];
        })->each(function ($item) {
            ItemMst::where('ITEM_ID', $item['ITEM_ID'])->update($item);
        });

        return response()->json([
            'success' => true,
            'message' => __('Successfully synced'),
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
        $itemNm = $request->input('item_nm');
        $itemId = $request->input('item_id');
        $itemCd = $request->input('item_cd');

        return Excel::download(new ItemMstExport($itemNm, $itemId, $itemCd), 'ITEM-MST-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $result = Excel::import(new ItemMstImport(), $request->file('file'));
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
