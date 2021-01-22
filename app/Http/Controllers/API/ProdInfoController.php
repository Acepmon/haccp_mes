<?php

namespace App\Http\Controllers\API;

//use App\Exports\ProdInfoExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProdInfoResource;
use App\Imports\ProdInfoImport;
use App\ProdInfo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProdInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = ProdInfo::query();
        $limit = $request->input('limit', 20);
        $sort = $request->input('sort', 'ACC_NO');
        $order = $request->input('order', 'DESC');

        if ($request->has('key_word')) {
            $keyWord = $request->input('key_word');
            $items = $items->where('ACC_NO', 'LIKE', '%'.$keyWord.'%')->orWhere('ITEM_ID', 'LIKE', '%'.$keyWord.'%')
            ->orWhere('ITEM_NM', 'LIKE', '%'.$keyWord.'%')->orWhere('SPEC', 'LIKE', '%'.$keyWord.'%')->orWhere('LOT_NO', 'LIKE', '%'.$keyWord.'%');
        }

        if ($limit == -1) {
            $items = $items->orderBy($sort, $order)->get();
        } else {
            $items = $items->orderBy($sort, $order)->paginate($limit);
        }
        return ProdInfoResource::collection($items);
    }

    public function sync(Request $request)
    {
        // $request->validate([
        //     'sync' => 'required|array'
        // ]);

        // collect($request->input('sync'))->map(function ($item) {
        //     return [
        //         'COMP_ID' => $item['Prod_info:comp_id'],
        //         'COMP_NM' => $item['Prod_info:comp_nm'],
        //         'CEO_NM' => $item['Prod_info:ceo_nm'],
        //         'MOB_NO' => $item['Prod_info:mob_no'],
        //         'Prod_NM' => $item['Prod_info:Prod_nm'],
        //         'Prod_NO' => $item['Prod_info:Prod_no'],
        //         'TEL_NO' => $item['Prod_info:tel_no'],
        //         'FAX_NO' => $item['Prod_info:fax_no'],
        //         'SRH_INFO' => $item['Prod_info:srh_no'],
        //         'EMAIL' => $item['Prod_info:email'],
        //         'GRP_NM' => $item['Prod_info:grp_nm'],
        //         'ADDR' => $item['Prod_info:addr'],
        //         'REMARK' => $item['Prod_info:remark'],
        //         'USE_YN' => $item['Prod_info:use_yn']
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

    //     return Excel::download(new ProdInfoExport($keyWord), 'Prod-INFO' . now()->format('Y-m-d') . '.xlsx');
    // }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        ProdInfo::truncate();

        $result = Excel::import(new ProdInfoImport(), $request->file('file'));
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
