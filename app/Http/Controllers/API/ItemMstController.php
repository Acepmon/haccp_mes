<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemMstResource;
use App\ItemMst;
use Illuminate\Http\Request;

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
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'ASC');

        if ($request->has('item_nm')) {
            $itemNm = $request->input('item_nm');
            $items = $items->where('ITEM_NM', 'LIKE', '%'.$itemNm.'%');
        }

        if ($request->has('item_id')) {
            $itemDesc = $request->input('item_id');
            $items = $items->where('ITEM_ID', 'LIKE', '%'.$itemDesc.'%');
        }

        if ($request->has('item_cd')) {
            $typeCd = $request->input('item_cd');
            $items = $items->where('ITEM_CD', $typeCd);
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return ItemMstResource::collection($items);
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
        // 
    }
}
