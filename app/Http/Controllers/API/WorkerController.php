<?php

namespace App\Http\Controllers\API;

use App\Exports\WorkerExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\WorkerResource;
use App\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Worker::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'reg_dtm');
        $order = $request->input('order', 'asc');

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return WorkerResource::collection($items);
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
            'worker:worker_nm' => 'required|string|max:60',
            'worker:tel_no' => 'required|string|max:20',
            'worker:work_cd' => 'nullable|string|max:20',
            'worker:health_chk_dt' => 'nullable|string|date_format:Y-m-d',
            'worker:role_cd' => 'nullable|string|max:20',
            'worker:remark' => 'nullable|string|max:100',
        ]);

        $item = Worker::create([
            'WORKER_NM' => $request->input('worker:worker_nm'),
            'TEL_NO' => $request->input('worker:tel_no'),
            'WORK_CD' => $request->input('worker:work_cd'),
            'HEALTH_CHK_DT' => now()->parse($request->input('worker:health_chk_dt'))->format('Ymd'),
            'ROLE_CD' => $request->input('worker:role_cd'),
            'REMARK' => $request->input('worker:remark'),
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ]);

        return response()->json([
            'success' => true,
            'result' => new WorkerResource($item),
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
        $item = Worker::where('WORKER_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Worker data not found')
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => new WorkerResource($item),
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
        $item = Worker::where('WORKER_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Worker data not found')
            ], 422);
        }

        $request->validate([
            'worker_nm' => 'worker:required|string|max:60',
            'tel_no' => 'worker:required|string|max:20',
            'work_cd' => 'worker:nullable|string|max:20',
            'health_chk_dt' => 'worker:nullable|string|date_format:Y-m-d',
            'role_cd' => 'worker:nullable|string|max:20',
            'remark' => 'worker:nullable|string|max:100',
        ]);

        $item->update([
            'WORKER_NM' => $request->input('worker:worker_nm'),
            'TEL_NO' => $request->input('worker:tel_no'),
            'WORK_CD' => $request->input('worker:work_cd'),
            'HEALTH_CHK_DT' => now()->parse($request->input('worker:health_chk_dt'))->format('Ymd'),
            'ROLE_CD' => $request->input('worker:role_cd'),
            'REMARK' => $request->input('worker:remark'),
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ]);

        return response()->json([
            'success' => true,
            'result' => new WorkerResource($item),
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
        $item = Worker::where('WORKER_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Worker data not found')
            ], 422);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => __('Worker data successfully deleted')
        ]);
    }

    public function download(Request $request)
    {
        return Excel::download(new WorkerExport(), 'WORKER-' . now()->format('Y-m-d') . '.xlsx');
    }
}
