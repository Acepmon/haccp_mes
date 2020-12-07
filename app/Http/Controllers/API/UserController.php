<?php

namespace App\Http\Controllers\API;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = User::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'reg_dtm');
        $order = $request->input('order', 'asc');

        $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);

        return UserResource::collection($items);
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
            'user_id' => 'required|string|max:15|unique:user,USER_ID',
            'user_pw' => 'nullable|string|max:100',
            'user_nm' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:50',
            'role_cd' => 'nullable|string|max:10',
            'appr_cd' => 'nullable|string|max:10',
            'job_cd' => 'nullable|string|max:10',
            'user_sts_yn' => 'nullable|string|in:' . implode(',', User::STATUS_ARRAY),
        ]);

        $user = User::create([
            'USER_ID' => $request->input('user_id'),
            'USER_PW' => Hash::make($request->input('user_pw')),
            'USER_NM' => $request->input('user_nm'),
            'EMAIL' => $request->input('email'),
            'ROLE_CD' => $request->input('role_cd'),
            'APPR_CD' => $request->input('appr_cd'),
            'JOB_CD' => $request->input('job_cd'),
            'USER_STS_YN' => $request->input('user_sts_yn'),
            'REG_DTM' => now()->format('YmdHis')
        ]);

        return response()->json([
            'success' => true,
            'result' => $user,
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
        $user = User::findOrFail($id);

        return new UserResource($user);
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
            'user_id' => 'required|string|max:15|unique:user,USER_ID,' . $id . ',USER_ID',
            'user_pw' => 'nullable|string|max:100',
            'user_nm' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:50',
            'role_cd' => 'nullable|string|max:10',
            'appr_cd' => 'nullable|string|max:10',
            'job_cd' => 'nullable|string|max:10',
            'user_sts_yn' => 'nullable|string|in:' . implode(',', User::STATUS_ARRAY),
        ]);

        $user = User::where('USER_ID', $id)->first();
        $user->update([
            'USER_ID' => $request->input('user_id'),
            'USER_PW' => Hash::make($request->input('user_pw')),
            'USER_NM' => $request->input('user_nm'),
            'EMAIL' => $request->input('email'),
            'ROLE_CD' => $request->input('role_cd'),
            'APPR_CD' => $request->input('appr_cd'),
            'JOB_CD' => $request->input('job_cd'),
            'USER_STS_YN' => $request->input('user_sts_yn'),
        ]);

        return response()->json([
            'success' => true,
            'result' => $user,
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
        $user = User::where('USER_ID', $id)->first();
        $user->delete();

        return response()->json([
            'success' => true,
            'results' => __('Successfully deleted user record.')
        ]);
    }

    public function download(Request $request)
    {
        return Excel::download(new UserExport(), 'USER-' . now()->format('Y-m-d') . '.xlsx');
    }
}
