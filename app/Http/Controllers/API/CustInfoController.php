<?php

namespace App\Http\Controllers\API;

use App\Exports\CustInfoExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustInfoResource;
use App\Imports\CustInfoImport;
use App\CustInfo;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CustInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = CustInfo::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 20);
        $sort = $request->input('sort', 'CUST_ID');
        $order = $request->input('order', 'ASC');

        if ($request->has('cust_nm')) {
            $custNm = $request->input('cust_nm');
            $items = $items->where('CUST_NM', 'LIKE', '%'.$custNm.'%');
        }

        if ($request->has('cust_id')) {
            $custID = $request->input('cust_id');
            $items = $items->where('CUST_ID', 'LIKE', '%'.$custID.'%');
        }

        if ($limit == -1) {
            $items = $items->with($with)->get();
        } else {
            $items = $items->with($with)->paginate($limit);
        }

        return CustInfoResource::collection($items);
    }

    public function sync(Request $request)
    {
        $request->validate([
            'sync' => 'required|array'
        ]);

        // collect($request->input('sync'))->map(function ($item) {
        //     return [
        //         'cust_id' => $item['item_mst:cust_id'],
        //         'UNIT1_NM' => $item['item_mst:unit1_nm'],
        //         'UNIT1_QTY' => $item['item_mst:unit1_qty'],
        //         'UNIT2_NM' => $item['item_mst:unit2_nm'],
        //         'UNIT2_QTY' => $item['item_mst:unit2_qty'],
        //         'UNIT3_NM' => $item['item_mst:unit3_nm'],
        //         'UNIT3_QTY' => $item['item_mst:unit3_qty'],
        //     ];
        // })->each(function ($item) {
        //     CustInfo::where('cust_id', $item['cust_id'])->update($item);
        //     CustInfo::where('cust_id', $item['cust_id'])->update([
        //         'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
        //         'REG_DTM' => now()->format('Ymdhis'),
        //     ]);
        // });

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
        $custNm = $request->input('cust_nm');
        $custID = $request->input('cust_id');
     
        return Excel::download(new CustInfoExport($custNm, $custID), 'CUST-INFO' . now()->format('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $result = Excel::import(new CustInfoImport(), $request->file('file'));
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
