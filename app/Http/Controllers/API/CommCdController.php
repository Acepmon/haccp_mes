<?php

namespace App\Http\Controllers\API;

use App\CommCd;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommCdResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommCdController extends Controller
{
    public function code(Request $request)
    {
        $cd1 = $request->input('cd1');
        $cd2 = $request->input('cd2');

        if ($request->has('cd2')) {
            $items = DB::select('select haccp_mes.get_codename(?, ?) as comm2_nm', [$cd1, $cd2]);
        } else {
            $items = DB::select('call haccp_mes.get_codelist(?)', [$cd1]);
        }

        return response()->json($items);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 15);
        $paginate = $request->input('paginate', true);
        $items = CommCd::query();

        if ($paginate) {
            $items = $items->paginate($limit);
        } else {
            $items = $items->get();
        }

        return CommCdResource::collection($items);
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
