<?php

namespace App\Http\Controllers\APP;

use App\EdocFile;
use App\CommCd;
use App\Worker;
use App\WorkerAttn;
use App\Http\Resources\AppGetDocDailyListResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function apprequest(Request $request)
    {
        $request->validate([
            'request_type' => 'required'
        ]);

        $type = $request->input('request_type');

        switch ($type) {
            case 'get_doc_daily_list': return $this->getDocDailyList($request);
            case 'apply_attendance': return $this->applyAttendance($request);
            case 'apply_leave_work': return $this->applyLeaveWork($request);
            default:
                return $this->jsonResponse([
                    'status' => 'error',
                    'msg' => 'Request type incorrect'
                ], 422);
        }
    }

    public function getDocDailyList(Request $request)
    {
        $items = EdocFile::query();

        $sort = $request->input('sort', 'DOC_ID');
        $order = $request->input('order', 'ASC');

        // $inputs = collect($request->input());

        // $paramsWithVal = $inputs->map(function ($key, $val) {
        //     return [
        //         'key' => $key,
        //         'val' => $val
        //     ];
        // });

        // $params = array_map(function($val) use ($paramsWithVal) {
        //     return $paramsWithVal->get($val);
        // }, array_keys($request->input()));

        // return response()->json($params);

        $type = $request->input('type');
        if ($request->has('type')) {
            $typeCd = CommCd::where('COMM1_CD', 'A40')->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_NM', $type)->value('COMM2_CD');
            $items = $items->where('TYPE_CD', $typeCd);
        }

        $items = $items->where('PERIOD_CD', 'ED');
        $items = $items->orderBy($sort, $order)->get();

        return $this->jsonResponse([
            'status' => 'success',
            'msg' => '',
            'data' => AppGetDocDailyListResource::collection($items)
        ]);
    }

    public function applyAttendance(Request $request)
    {
        $request->validate([
            'input' => 'required|numeric'
        ]);

        $input = $request->input('input');

        if (!Worker::where('PASS_NO', $input)->exists()) {
            return $this->jsonResponse([
                'status' => 'error',
                'msg' => '번호를 잘못 입력하였습니다. (개인번호를 확인하세요)'
            ], 422);
        }

        $worker = Worker::where('PASS_NO', $input)->first();
        $today = now()->format('Ymd');

        if (WorkerAttn::where('EMP_ID', $worker->EMP_ID)->where('ON_DTM', 'LIKE', $today . '%')->exists()) {
            return $this->jsonResponse([
                'status' => 'error',
                'msg' => $worker->EMP_NM . '님은 오늘날짜 출근기록이 이미 기록되이있습니다.'
            ], 422);
        }

        $workerAttn = WorkerAttn::create([
            'EMP_ID' => $worker->EMP_ID,
            'ON_DTM' => now()->format('Ymdhis'),
        ]);

        return $this->jsonResponse([
            'status' => 'success',
            'msg' => $worker->EMP_NM . '님 출근기록이 되었습니다.',
            'time' => now()->parse($workerAttn->ON_DTM)->format('Y-m-d H:i'),
        ], 200);
    }

    public function applyLeaveWork(Request $request)
    {
        $request->validate([
            'input' => 'required|numeric'
        ]);

        $input = $request->input('input');

        if (!Worker::where('PASS_NO', $input)->exists()) {
            return $this->jsonResponse([
                'status' => 'error',
                'msg' => '번호를 잘못 입력하였습니다. (개인번호를 확인하세요)'
            ], 422);
        }

        $worker = Worker::where('PASS_NO', $input)->first();
        $today = now()->format('Ymd');

        if (!WorkerAttn::where('EMP_ID', $worker->EMP_ID)->where('ON_DTM', 'LIKE', $today . '%')->exists()) {
            return $this->jsonResponse([
                'status' => 'error',
                'msg' => $worker->EMP_NM . '님은 출근기록이 없이 퇴근기록을 할 수 없습니다.'
            ], 422);
        }

        if (WorkerAttn::where('EMP_ID', $worker->EMP_ID)->where('ON_DTM', 'LIKE', $today . '%')->whereNotNull('OFF_DTM')->exists()) {
            return $this->jsonResponse([
                'status' => 'error',
                'msg' => $worker->EMP_NM . '님은 오늘날짜 퇴근기록이 이미 기록되이있습니다.'
            ], 422);
        }

        $offDtm = now()->format('Ymdhis');
        WorkerAttn::where('EMP_ID', $worker->EMP_ID)->where('ON_DTM', 'LIKE', $today . '%')->update([
            'OFF_DTM' => $offDtm
        ]);

        return $this->jsonResponse([
            'status' => 'success',
            'msg' => $worker->EMP_NM . '님 퇴근기록이 되었습니다.',
            'time' => now()->parse($offDtm)->format('Y-m-d H:i'),
        ], 200);
    }
}
