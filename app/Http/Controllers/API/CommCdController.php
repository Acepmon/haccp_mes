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
    public function index()
    {
        $commCd = CommCd::paginate();

        return CommCdResource::collection($commCd);
    }

    public function roles(Request $request)
    {
        $limit = $request->input('limit', 15);
        $commCd = CommCd::where('comm1_cd', 'A10')->whereNotIn('comm2_cd', ['$$'])->paginate($limit);

        return CommCdResource::collection($commCd);
    }

    public function jobs(Request $request)
    {
        $limit = $request->input('limit', 15);
        $commCd = CommCd::where('comm1_cd', 'Z10')->whereNotIn('comm2_cd', ['$$'])->paginate($limit);

        return CommCdResource::collection($commCd);
    }

    public function approvals(Request $request)
    {
        $limit = $request->input('limit', 15);
        $commCd = CommCd::where('comm1_cd', 'B10')->whereNotIn('comm2_cd', ['$$'])->paginate($limit);

        return CommCdResource::collection($commCd);
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
