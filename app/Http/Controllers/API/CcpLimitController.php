<?php

namespace App\Http\Controllers\API;

use App\CcpLimit;
use App\CommCd;
use App\Http\Controllers\Controller;
use App\Http\Resources\CcpLimitResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CcpLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = CcpLimit::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'DESC');
        $device_id = $request->input('device_id');

        if ($request->has('device_id')) {
            $items = $items->whereIn('DEVICE_ID', array_filter(explode(',', $device_id)));
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return CcpLimitResource::collection($items);
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
    public function show($deviceId)
    {
        if (CcpLimit::where('DEVICE_ID', $deviceId)->exists()) {
            $item = CcpLimit::where('DEVICE_ID', $deviceId)->first();
        } else {
            $item = CcpLimit::create(
                [
                    'DEVICE_ID' => $deviceId,
                    'LMT_UP' => null,
                    'LMT_DN' => null,
                    'REMARK' => null,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'result' => new CcpLimitResource($item),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $deviceId)
    {
        $request->validate([
            'ccp_limit:device_id' => 'required',
            'ccp_limit:lmt_up' => 'required|numeric',
            'ccp_limit:lmt_dn' => 'required|numeric',
            'ccp_limit:remark' => 'nullable|string|max:100',
        ]);

        $item = CcpLimit::updateOrCreate(
            ['DEVICE_ID' => $deviceId],
            [
                'DEVICE_ID' => $request->input('ccp_limit:device_id'),
                'LMT_UP' => $request->input('ccp_limit:lmt_up'),
                'LMT_DN' => $request->input('ccp_limit:lmt_dn'),
                'REMARK' => $request->input('ccp_limit:remark'),
                'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                'REG_DTM' => now()->format('Ymdhis'),
            ]
        );

        return response()->json([
            'success' => true,
            'result' => new CcpLimitResource($item),
        ]);
    }

    public function patch(Request $request)
    {
        $request->validate([
            'ccp_limit:device_id' => 'required',
            'ccp_limit:src_cd' => 'required',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($deviceId)
    {
        CcpLimit::where('DEVICE_ID', $deviceId)->update([
            'LMT_UP' => null,
            'LMT_DN' => null,
            'REMARK' => null,
        ]);

        return response()->json([
            'success' => true,
            'result' => __('CCP limit successfully cleared'),
        ]);
    }
}
