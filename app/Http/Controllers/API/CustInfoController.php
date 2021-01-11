<?php

namespace App\Http\Controllers\API;

use App\Exports\CustInfoExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustInfoResource;
use App\Imports\CustInfoImport;
use App\CustInfo;
use Illuminate\Http\Request;
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
        $limit = $request->input('limit', 20);
        $sort = $request->input('sort', 'COMP_ID');
        $order = $request->input('order', 'ASC');

        if ($request->has('comp_nm')) {
            $compNm = $request->input('comp_nm');
            $items = $items->where('COMP_NM', 'LIKE', '%'.$compNm.'%')->orWhere('CEO_NM', 'LIKE', '%'.$compNm.'%')->orWhere('CUST_NM', 'LIKE', '%'.$compNm.'%');
            //$items = $items->where('COMP_NM', 'LIKE', '%'.$compNm.'%');
           //dd($items);
        }

        // if ($request->has('cust_id')) {
        //     $custID = $request->input('cust_id');
        //     $items = $items->where('CUST_ID', 'LIKE', '%'.$custID.'%');
        // }
        // if ($request->has('groupBy')) {
        //     $items = $items->whereIn('ITEM_ID', function ($query) {
        //         $query->select('ITEM1_ID')->from('BOM_CONFIG')->groupBy('ITEM1_ID');
        //     });
        // }

        // if ($limit == -1) {
        //     $items = $items->with($with)->get();
        // } else {
        //     $items = $items->with($with)->paginate($limit);
        // }
        if ($limit == -1) {
            $items = $items->get();
        } else {
            $items = $items->paginate($limit);
        }
        return CustInfoResource::collection($items);
    }

    public function sync(Request $request)
    {
        // $request->validate([
        //     'sync' => 'required|array'
        // ]);

        // collect($request->input('sync'))->map(function ($item) {
        //     return [
        //         'COMP_ID' => $item['cust_info:comp_id'],
        //         'COMP_NM' => $item['cust_info:comp_nm'],
        //         'CEO_NM' => $item['cust_info:ceo_nm'],
        //         'MOB_NO' => $item['cust_info:mob_no'],
        //         'CUST_NM' => $item['cust_info:cust_nm'],
        //         'CUST_NO' => $item['cust_info:cust_no'],
        //         'TEL_NO' => $item['cust_info:tel_no'],
        //         'FAX_NO' => $item['cust_info:fax_no'],
        //         'SRH_INFO' => $item['cust_info:srh_no'],
        //         'EMAIL' => $item['cust_info:email'],
        //         'GRP_NM' => $item['cust_info:grp_nm'],
        //         'ADDR' => $item['cust_info:addr'],
        //         'REMARK' => $item['cust_info:remark'],
        //         'USE_YN' => $item['cust_info:use_yn']
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
        $custNm = $request->input('cust_nm');
        $custID = $request->input('cust_id');
     
        return Excel::download(new CustInfoExport($custNm, $custID), 'CUST-INFO' . now()->format('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        CustInfo::truncate();

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
