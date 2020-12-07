<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoginHistResource;
use App\LoginHist;
use Illuminate\Http\Request;

class LoginHistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'from' => 'nullable|date_format:Y-m-d',
            'to' => 'nullable|date_format:Y-m-d',
            'keyword' => 'nullable|string'
        ]);

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'login_dtm');
        $order = $request->input('order', 'desc');
        
        $to = $request->input('to');
        $keyword = $request->input('keyword');

        $loginHist = LoginHist::query();

        if ($request->has('from')) {
            $from = $request->input('from');
            $loginHist = $loginHist->whereDate('reg_dtm', '>=', $from);
        }

        if ($request->has('to')) {
            $to = $request->input('to');
            $loginHist = $loginHist->whereDate('reg_dtm', '>=', $to);
        }

        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $loginHist = $loginHist->where('user_id', 'LIKE', '%' . $keyword . '%');
            $loginHist = $loginHist->where('user_nm', 'LIKE', '%' . $keyword . '%');
        }

        $loginHist = $loginHist->with($with)->orderBy($sort, $order)->paginate($limit);

        return LoginHistResource::collection($loginHist);
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
        $loginHist = LoginHist::where('user_id', $id)->paginate();

        return LoginHistResource::collection($loginHist);
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
