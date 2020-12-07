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

        $items = LoginHist::query();

        if ($request->has('keyword') && !empty($request->input('keyword'))) {
            $keyword = $request->input('keyword');
            $items = $items->where('USER_ID', 'LIKE', '%' . $keyword . '%');
            $items = $items->orWhereHas('user', function ($query) use ($keyword) {
                return $query->where('USER_NM', 'LIKE', '%' . $keyword . '%');
            });
        }

        if ($request->has('from') && !empty($request->input('from'))) {
            $from = $request->input('from');
            $items = $items->whereDate('LOGIN_DTM', '>=', now()->parse($from)->format('YmdHis'));
        }

        if ($request->has('to') && !empty($request->input('to'))) {
            $to = $request->input('to');
            $items = $items->whereDate('LOGIN_DTM', '<=', now()->parse($to)->format('YmdHis'));
        }

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 50);
        $sort = $request->input('sort', 'LOGIN_DTM');
        $order = $request->input('order', 'asc');

        $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);

        return LoginHistResource::collection($items);
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
        $loginHist = LoginHist::where('USER_ID', $id)->paginate();

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
