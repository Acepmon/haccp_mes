<?php

namespace App\Http\Controllers\API;

use App\CcpEscData;
use App\Http\Controllers\Controller;
use App\Http\Resources\CcpEscDataResource;
use Illuminate\Http\Request;

class CcpEscDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = CcpEscData::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'DESC');

        if ($request->has('from') && !empty($request->input('from'))) {
            $from = $request->input('from');
            $items = $items->where('SRT_DTM', 'LIKE', now()->parse($from)->format('Ymd') . '%');
        }

        if ($request->has('to') && !empty($request->input('to'))) {
            $to = $request->input('to');
            $items = $items->where('END_DTM', 'LIKE', now()->parse($to)->format('Ymd') . '%');
        }

        if ($request->has('lmt_up') && !empty($request->input('lmt_up'))) {
            $lmtUp = $request->input('lmt_up');
            $items = $items->whereHas('ccp_limit', function ($query) use ($lmtUp) {
                $query->where('LMT_UP', intval($lmtUp));
            });
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return CcpEscDataResource::collection($items);
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
        $request->validate([
            'ccp_esc_data:device_id' => 'required',
            'ccp_esc_data:srt_dtm' => 'required',
            'ccp_esc_data:reason' => 'nullable|string|max:300'
        ]);

        CcpEscData::where('DEVICE_ID', $request->input('ccp_esc_data:device_id'))
            ->where('SRT_DTM', $request->input('ccp_esc_data:srt_dtm'))
            ->update([
                'REASON' => $request->input('ccp_esc_data:reason')
            ]);

        return response()->json([
            'success' => true,
        ]);
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
