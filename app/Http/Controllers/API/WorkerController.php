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
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'DESC');

        if ($request->has('duty_cd')) {
            $items = $items->where('DUTY_CD', $request->input('duty_cd'));
        }

        if ($request->has('dept_cd')) {
            $items = $items->where('DEPT_CD', $request->input('dept_cd'));
        }

        if ($request->has('role_cd')) {
            $items = $items->where('ROLE_CD', $request->input('role_cd'));
        }

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
            "worker:emp_id" => "required|string|max:15|unique:WORKER,EMP_ID",
            "worker:emp_nm" => "nullable|string|max:20",
            "worker:duty_cd" => "nullable|string|max:20",
            "worker:mob_no" => "nullable|string|max:20",
            "worker:pass_no" => "nullable|string|max:10",
            "worker:dept_cd" => "nullable|string|max:20",
            "worker:in_dt" => "nullable|string|date_format:Y-m-d",
            "worker:out_dt" => "nullable|string|date_format:Y-m-d",
            "worker:jumin_no" => "nullable|string|max:20",
            "worker:birth_dt" => "nullable|string|date_format:Y-m-d",
            "worker:bank_nm" => "nullable|string|max:20",
            "worker:acct_no" => "nullable|string|max:30",
            "worker:address" => "nullable|string|max:100",
            "worker:email" => "nullable|string|email|max:30",
            "worker:main_job" => "nullable|string|max:100",
            "worker:health_chk_dt" => "nullable|string|date_format:Y-m-d",
            "worker:haccp_doc" => "nullable|string|max:100",
            "worker:role_cd" => "nullable|string|max:20",
            "worker:haccp_role" => "nullable|string|max:100",
        ]);

        $item = Worker::create([
            'EMP_ID' => $request->input('worker:emp_id'),
            'EMP_NM' => $request->input('worker:emp_nm'),
            'DUTY_CD' => $request->input('worker:duty_cd'),
            'MOB_NO' => $request->input('worker:mob_no'),
            'PASS_NO' => $request->input('worker:pass_no'),
            'DEPT_CD' => $request->input('worker:dept_cd'),
            'IN_DT' => now()->parse($request->input('worker:in_dt'))->format('Ymd'),
            'OUT_DT' => now()->parse($request->input('worker:out_dt'))->format('Ymd'),
            'JUMIN_NO' => $request->input('worker:jumin_no'),
            'BIRTH_DT' => now()->parse($request->input('worker:birth_dt'))->format('Ymd'),
            'BANK_NM' => $request->input('worker:bank_nm'),
            'ACCT_NO' => $request->input('worker:acct_no'),
            'ADDRESS' => $request->input('worker:address'),
            'EMAIL' => $request->input('worker:email'),
            'MAIN_JOB' => $request->input('worker:main_job'),
            'HEALTH_CHK_DT' => now()->parse($request->input('worker:health_chk_dt'))->format('Ymd'),
            'HACCP_DOC' => $request->input('worker:haccp_doc'),
            'ROLE_CD' => $request->input('worker:role_cd'),
            'HACCP_ROLE' => $request->input('worker:haccp_role'),
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
        $item = Worker::where('EMP_ID', $id)->first();

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
        $item = Worker::where('EMP_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Worker data not found')
            ], 422);
        }

        $request->validate([
            "worker:emp_nm" => "nullable|string|max:20",
            "worker:duty_cd" => "nullable|string|max:20",
            "worker:mob_no" => "nullable|string|max:20",
            "worker:pass_no" => "nullable|string|max:10",
            "worker:dept_cd" => "nullable|string|max:20",
            "worker:in_dt" => "nullable|string|date_format:Y-m-d",
            "worker:out_dt" => "nullable|string|date_format:Y-m-d",
            "worker:jumin_no" => "nullable|string|max:20",
            "worker:birth_dt" => "nullable|string|date_format:Y-m-d",
            "worker:bank_nm" => "nullable|string|max:20",
            "worker:acct_no" => "nullable|string|max:30",
            "worker:address" => "nullable|string|max:100",
            "worker:email" => "nullable|string|email|max:30",
            "worker:main_job" => "nullable|string|max:100",
            "worker:health_chk_dt" => "nullable|string|date_format:Y-m-d",
            "worker:haccp_doc" => "nullable|string|max:100",
            "worker:role_cd" => "nullable|string|max:20",
            "worker:haccp_role" => "nullable|string|max:100",
        ]);

        $item->update([
            'EMP_NM' => $request->input('worker:emp_nm'),
            'DUTY_CD' => $request->input('worker:duty_cd'),
            'MOB_NO' => $request->input('worker:mob_no'),
            'PASS_NO' => $request->input('worker:pass_no'),
            'DEPT_CD' => $request->input('worker:dept_cd'),
            'IN_DT' => now()->parse($request->input('worker:in_dt'))->format('Ymd'),
            'OUT_DT' => now()->parse($request->input('worker:out_dt'))->format('Ymd'),
            'JUMIN_NO' => $request->input('worker:jumin_no'),
            'BIRTH_DT' => now()->parse($request->input('worker:birth_dt'))->format('Ymd'),
            'BANK_NM' => $request->input('worker:bank_nm'),
            'ACCT_NO' => $request->input('worker:acct_no'),
            'ADDRESS' => $request->input('worker:address'),
            'EMAIL' => $request->input('worker:email'),
            'MAIN_JOB' => $request->input('worker:main_job'),
            'HEALTH_CHK_DT' => now()->parse($request->input('worker:health_chk_dt'))->format('Ymd'),
            'HACCP_DOC' => $request->input('worker:haccp_doc'),
            'ROLE_CD' => $request->input('worker:role_cd'),
            'HACCP_ROLE' => $request->input('worker:haccp_role'),
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
        $item = Worker::where('EMP_ID', $id)->first();

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
