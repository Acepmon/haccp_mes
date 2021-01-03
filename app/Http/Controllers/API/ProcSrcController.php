<?php

namespace App\Http\Controllers\API;

use App\ProcSrc;
use App\Http\Resources\ProcSrcResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProcSrcController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = ProcSrc::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'DESC');

        if ($request->has('item_nm')) {
            $itemNm = $request->input('item_nm');
            $items = $items->whereHas('item_mst', function ($query) use ($itemNm) {
                $query->where('ITEM_NM', 'LIKE', '%'.$itemNm.'%');
            });
        }

        $items = $items->whereIn('ITEM_ID', function ($query) {
            $query->select('ITEM_ID')->from('ITEM_MST')->groupBy('ITEM_ID');
        });

        if ($limit == -1) {
            $items = $items->with($with)->get();
        } else {
            $items = $items->with($with)->paginate($limit);
        }

        return ProcSrcResource::collection($items);
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
