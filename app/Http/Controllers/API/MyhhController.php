<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\MyhhExport;
use App\Http\Resources\MyhhResource;
use App\Myhh;
use Maatwebsite\Excel\Facades\Excel;

class MyhhController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Myhh::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'reg_dtm');
        $order = $request->input('order', 'asc');

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return MyhhResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'myhh:myhh_id' => 'required|string|max:60',
            'myhh:myhh_nm' => 'nullable|string|max:20',
            'myhh:user_sts_yn' => 'required|string|max:1',
            'myhh:Reg_dtm' => 'required|string|date_format:Y-m-d',
        ]);

        $item = Myhh::create([
            'myhh_ID' => $request->input('myhh:myhh_id'),
            'myhh_NM' => $request->input('myhh:myhh_nm'),
            'USER_STS_YN' => $request->input('myhh:user_sts_yn'),
            'REG_DTM' => now()->format('Ymdhis'),
        ]);

        return response()->json([
            'success' => true,
            'result' => new MyhhResource($item),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Myhh::where('MYHH_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Myhh data not found')
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => new MyhhResource($item),
        ]);
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
        $item = Myhh::where('MYHH_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Myhh data not found')
            ], 422);
        }

        $request->validate([
            'myhh:myhh_id' => 'required|string|max:60',
            'myhh:myhh_nm' => 'required|string|max:60',
        ]);

        $item->update([
            'MYHH_ID' => $request->input('myhh:myhh_id'),
            'MYHH_NM' => $request->input('myhh:myhh_nm'),
            'USER_STS_YN' => $request->input('myhh:User_sts_yn'),
            'REG_DTM' => now()->format('Ymdhis'),
        ]);

        return response()->json([
            'success' => true,
            'result' => new MyhhResource($item),
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
        $item = Myhh::where('MYHH_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Myhh data not found')
            ], 422);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => __('Myhh data successfully deleted')
        ]);
    }

    public function download(Request $request)
    {
        return Excel::download(new MyhhExport(), 'MYHH-' . now()->format('Y-m-d') . '.xlsx');
    }
}
