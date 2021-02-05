<?php

namespace App\Http\Controllers\API;

//use App\Exports\LotInfoExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\LotInfoResource;
use App\Imports\LotInfoImport;
use App\LotInfo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LotInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = LotInfo::query();
        $limit = $request->input('limit', 20);
        $sort = $request->input('sort', 'DT_NO');
        $order = $request->input('order', 'DESC');

        if ($request->has('key_word')) {
            $keyWord = $request->input('key_word');
            $items = $items->where('DT_NO', 'LIKE', '%'.$keyWord.'%')->orWhere('ITEM_ID', 'LIKE', '%'.$keyWord.'%')
            ->orWhere('ITEM_NM', 'LIKE', '%'.$keyWord.'%')->orWhere('LOT_NO', 'LIKE', '%'.$keyWord.'%')
            ->orWhere('ACC_NO', 'LIKE', '%'.$keyWord.'%');
        }

        if ($request->has('acc_no')) {
            $items = $items->where('ACC_NO', $request->input('acc_no'));
        }

        if ($request->has('item_id')) {
            $items = $items->where('ITEM_ID', $request->input('item_id'));
        }

        if ($limit == -1) {
            $items = $items->orderBy($sort, $order)->get();
        } else {
            $items = $items->orderBy($sort, $order)->paginate($limit);
        }
        return LotInfoResource::collection($items);
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

    // public function export(Request $request)
    // {
    //     $keyWord = $request->input('comp_nm');

    //     return Excel::download(new LotInfoExport($keyWord), 'Lot-INFO' . now()->format('Y-m-d') . '.xlsx');
    // }

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
