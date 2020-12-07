<?php

namespace App\Http\Controllers\API;

use App\CommCd;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommCdResource;
use Illuminate\Http\Request;

class CommCdController extends Controller
{
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

    public function roles(Request $request)
    {
        $limit = $request->input('limit', 15);
        $paginate = $request->input('paginate', true);
        $items = CommCd::where('COMM1_CD', 'A10')->whereNotIn('COMM2_CD', ['$$']);

        if ($paginate) {
            $items = $items->paginate($limit);
        } else {
            $items = $items->get();
        }

        return CommCdResource::collection($items);
    }

    public function approvals(Request $request)
    {
        $limit = $request->input('limit', 15);
        $paginate = $request->input('paginate', true);
        $items = CommCd::where('COMM1_CD', 'A20')->whereNotIn('COMM2_CD', ['$$']);

        if ($paginate) {
            $items = $items->paginate($limit);
        } else {
            $items = $items->get();
        }

        return CommCdResource::collection($items);
    }

    public function jobs(Request $request)
    {
        $limit = $request->input('limit', 15);
        $paginate = $request->input('paginate', true);
        $items = CommCd::where('COMM1_CD', 'A30')->whereNotIn('COMM2_CD', ['$$']);

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
