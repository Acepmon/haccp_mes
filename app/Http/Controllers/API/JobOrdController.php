<?php

namespace App\Http\Controllers\API;

use App\Exports\JobOrdExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobOrdResource;
use App\Imports\JobOrdImport;
use App\JobOrd;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JobOrdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = JobOrd::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'DESC');

        if ($request->has('from') && !empty($request->input('from'))) {
            $from = $request->input('from');
            $items = $items->whereDate('JOB_DT', '>=', now()->parse($from)->format('YmdHis'));
        }

        if ($request->has('to') && !empty($request->input('to'))) {
            $to = $request->input('to');
            $items = $items->whereDate('JOB_DT', '<=', now()->parse($to)->format('YmdHis'));
        }

        if ($request->has('groupBy')) {
            $items = $items->whereIn('ITEM_ID', function ($query) {
                $query->select('ITEM1_ID')->from('BOM_CONFIG')->groupBy('ITEM1_ID');
            });
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return JobOrdResource::collection($items);
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

        return Excel::download(new JobOrdExport($itemNm, $itemId, $itemCd), 'ITEM-MST-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        Excel::import(new JobOrdImport(), $request->file('file'));

        return response()->json([
            'success' => true,
            'message' => __('Successfully imported')
        ]);
    }
}
