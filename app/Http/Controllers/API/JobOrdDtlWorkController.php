<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobOrdDtlWorkResource;
use App\JobOrdDtlWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOrdDtlWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = JobOrdDtlWork::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'JOB_NO');
        $order = $request->input('order', 'DESC');

        if ($request->has('job_no')) {
            $items = $items->where('JOB_NO', $request->input('job_no'));
        }

        if ($request->has('item_id')) {
            $items = $items->where('ITEM_ID', $request->input('item_id'));
        }

        if ($request->has('seq_no')) {
            $items = $items->where('SEQ_NO', $request->input('seq_no'));
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return JobOrdDtlWorkResource::collection($items);
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
        //
    }

    public function sync(Request $request)
    {
        $request->validate([
            'sync' => 'required|array',
            'job_no' => 'required',
            'item_id' => 'required',
            'seq_no' => 'required',
        ]);

        $items = JobOrdDtlWork::query();
        $items = $items->where('JOB_NO', $request->input('job_no'));
        $items = $items->where('ITEM_ID', $request->input('item_id'));
        $items = $items->where('SEQ_NO', $request->input('seq_no'));
        $items->delete();

        collect($request->input('sync'))->each(function ($empId) use ($request) {
            JobOrdDtlWork::create([
                'JOB_NO' => $request->input('job_no'),
                'ITEM_ID' => $request->input('item_id'),
                'SEQ_NO' => $request->input('seq_no'),
                'EMP_ID' => $empId,
                'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                'REG_DTM' => now()->format('Ymdhis'),
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => __('Successfully saved'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $items = JobOrdDtlWork::query();

        if ($request->has('job_no')) {
            $items = $items->where('JOB_NO', $request->input('job_no'));
        }

        if ($request->has('item_id')) {
            $items = $items->where('ITEM_ID', $request->input('item_id'));
        }

        if ($request->has('seq_no')) {
            $items = $items->where('SEQ_NO', $request->input('seq_no'));
        }

        $items->delete();

        return response()->json([
            'success' => true,
            'result' => __('Successfully deleted'),
        ]);
    }
}
