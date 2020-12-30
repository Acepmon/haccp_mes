<?php

namespace App\Http\Controllers\API;

use App\BomConfig;
use App\Http\Controllers\Controller;
use App\Http\Resources\BomConfigResource;
use App\Http\Resources\ItemMstResource;
use App\Imports\BomConfigImport;
use App\ItemMst;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BomConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = BomConfig::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'ASC');

        if ($request->has('item1_id')) {
            $item1id = $request->input('item1_id');
            $items = $items->where('ITEM1_ID', $item1id);
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return BomConfigResource::collection($items);
    }

    public function sync(Request $request)
    {
        $request->validate([
            'sync' => 'required|array'
        ]);

        collect($request->input('sync'))->map(function ($item) {
            return [
                'ITEM1_ID' => $item['bom_config:item1_id'],
                'ITEM2_ID' => $item['bom_config:item2_id'],
                'PROD_QTY' => $item['bom_config:prod_qty'],
                'USE_QTY' => $item['bom_config:use_qty'],
            ];
        })->each(function ($item) {
            BomConfig::where('ITEM1_ID', $item['ITEM1_ID'])->where('ITEM2_ID', $item['ITEM2_ID'])->update($item);
        });

        return response()->json([
            'success' => true,
            'message' => __('Successfully saved'),
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $result = Excel::import(new BomConfigImport(), $request->file('file'));
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
