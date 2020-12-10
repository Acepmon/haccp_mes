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
            'worker_nm' => 'required|string|max:60',
            'tel_no' => 'required|string|max:20',
            'work_cd' => 'nullable|string|max:10',
            'health_chk_dt' => 'nullable|string|max:8',
            'role_cd' => 'nullable|string|max:10',
            'remark' => 'nullable|string|max:100',
        ]);

        $item = Worker::create([
            'WORKER_NM' => $request->input('worker_nm'),
            'TEL_NO' => $request->input('tel_no'),
            'WORK_CD' => $request->input('work_cd'),
            'HEALTH_CHK_DT' => $request->input('health_chk_dt'),
            'ROLE_CD' => $request->input('role_cd'),
            'REMARK' => $request->input('remark'),
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
        $item = Worker::find($id);

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
        $item = Worker::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Worker data not found')
            ], 422);
        }

        $request->validate([
            'worker_nm' => 'required|string|max:60',
            'tel_no' => 'required|string|max:20',
            'work_cd' => 'nullable|string|max:10',
            'health_chk_dt' => 'nullable|string|max:8',
            'role_cd' => 'nullable|string|max:10',
            'remark' => 'nullable|string|max:100',
        ]);

        $item->update([
            'WORKER_NM' => $request->input('worker_nm'),
            'TEL_NO' => $request->input('tel_no'),
            'WORK_CD' => $request->input('work_cd'),
            'HEALTH_CHK_DT' => $request->input('health_chk_dt'),
            'ROLE_CD' => $request->input('role_cd'),
            'REMARK' => $request->input('remark'),
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
        $item = Worker::find($id);

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
