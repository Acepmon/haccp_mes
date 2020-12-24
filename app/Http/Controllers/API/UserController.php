<?php

namespace App\Http\Controllers\API;

use App\Events\UserPasswordUpdated;
use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Auth\Events\Registered;
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

        if ($request->has('appr_cd')) {
            $items = $items->where('APPR_CD', $request->input('appr_cd'));
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

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
            'user:user_id' => 'required|string|max:15|unique:USER,USER_ID',
            'user:user_pw' => 'required|string|confirmed|max:100',
            'user:user_nm' => 'required|string|max:20',
            'user:email' => 'nullable|string|email|max:50',
            'user:role_cd' => 'required|array',
            'user:appr_cd' => 'required|array',
            'user:job_cd' => 'required|string|max:20',
            'user:user_sts_yn' => 'required|string|in:' . implode(',', User::STATUS_ARRAY),
        ]);

        $user = User::create([
            'USER_ID' => $request->input('user:user_id'),
            'USER_PW' => Hash::make($request->input('user:user_pw')),
            'USER_NM' => $request->input('user:user_nm'),
            'EMAIL' => $request->input('user:email'),
            'ROLE_CD' => implode(',', $request->input('user:role_cd')),
            'APPR_CD' => implode(',', $request->input('user:appr_cd')),
            'JOB_CD' => $request->input('user:job_cd'),
            'USER_STS_YN' => $request->input('user:user_sts_yn'),
            'REG_DTM' => now()->format('YmdHis')
        ]);

        event(new Registered($user));
        event(new UserPasswordUpdated($user, $request->input('user:user_pw'), 'Thank you for registering'));

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
            'user:user_id' => 'required|string|max:15|unique:USER,USER_ID,' . $id . ',USER_ID',
            'user:user_pw' => 'nullable|string|confirmed|max:100',
            'user:user_nm' => 'required|string|max:20',
            'user:email' => 'nullable|string|email|max:50',
            'user:role_cd' => 'required|array',
            'user:appr_cd' => 'required|array',
            'user:job_cd' => 'required|string|max:20',
            'user:user_sts_yn' => 'required|string|in:' . implode(',', User::STATUS_ARRAY),
        ]);

        $user = User::where('USER_ID', $id)->first();
        $user->update([
            'USER_ID' => $request->input('user:user_id'),
            'USER_NM' => $request->input('user:user_nm'),
            'EMAIL' => $request->input('user:email'),
            'ROLE_CD' => implode(',', $request->input('user:role_cd')),
            'APPR_CD' => implode(',', $request->input('user:appr_cd')),
            'JOB_CD' => $request->input('user:job_cd'),
            'USER_STS_YN' => $request->input('user:user_sts_yn'),
        ]);

        if ($request->has('user:user_pw') && !empty($request->input('user:user_pw'))) {
            $user->update([
                'USER_PW' => Hash::make($request->input('user:user_pw')),
            ]);

            event(new UserPasswordUpdated($user, $request->input('user:user_pw')));
        }

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
        $filename = 'USER:' . now()->format('Y-m-d') . '.xlsx';
        return Excel::download(new UserExport(), $filename);
    }

    public function password(Request $request, $userId)
    {
        $item = User::where('USER_ID', $userId)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('User data not found')
            ]);
        }

        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
        ]);

        $oldpw = $request->input('old_password');
        $newpw = $request->input('new_password');

        if (Hash::check($oldpw, $item->USER_PW)) {
            $item->USER_PW = Hash::make($newpw);
            $item->save();

            event(new UserPasswordUpdated($item, $request->input('new_password')));
        } else {
            return response()->json([
                'errors' => [
                    'old_password' => ['Old password was incorrect.']
                ],
                'message' => __('The given data was invalid.')
            ], 422);
        }

        return response()->json([
            'success' => true,
            'result' => new UserResource($item),
        ]);
    }
}
