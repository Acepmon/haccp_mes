<?php

namespace App\Http\Controllers\APP;

use App\EdocFile;
use App\CommCd;
use App\Worker;
use App\WorkerAttn;
use App\Http\Resources\AppGetDocDailyListResource;
use App\Http\Resources\AppGetCcpDocResource;
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
            case 'get_haccp_implementation_schedule': return $this->getHaccpImpSchedule($request);
            case 'get_ccp_doc_list_daily': return $this->getCcpDocListDaily($request);
            case 'get_ccp_doc_list_week': return $this->getCcpDocListWeek($request);
            case 'get_ccp_doc_list_month': return $this->getCcpDocListMonth($request);
            case 'get_ccp_doc_list_quarter': return $this->getCcpDocListQuarter($request);
            case 'get_ccp_doc_list_year': return $this->getCcpDocListYear($request);
            case 'get_haccp_doc_list_daily': return $this->getHaccpDocListDaily($request);
            case 'get_haccp_doc_list_week': return $this->getHaccpDocListWeek($request);
            case 'get_haccp_doc_list_month': return $this->getHaccpDocListMonth($request);
            case 'get_haccp_doc_list_quarter': return $this->getHaccpDocListQuarter($request);
            case 'get_haccp_doc_list_year': return $this->getHaccpDocListYear($request);
            default:
                return $this->jsonResponse([
                    'request_type' => $request->input('request_type'),
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
            'request_type' => $request->input('request_type'),
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
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => '번호를 잘못 입력하였습니다. (개인번호를 확인하세요)'
            ], 422);
        }

        $worker = Worker::where('PASS_NO', $input)->first();
        $today = now()->format('Ymd');

        if (WorkerAttn::where('EMP_ID', $worker->EMP_ID)->where('ON_DTM', 'LIKE', $today . '%')->exists()) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => $worker->EMP_NM . '님은 오늘날짜 출근기록이 이미 되이있습니다.'
            ], 422);
        }

        $workerAttn = WorkerAttn::create([
            'EMP_ID' => $worker->EMP_ID,
            'ON_DTM' => now()->format('Ymdhis'),
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
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
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => '번호를 잘못 입력하였습니다. (개인번호를 확인하세요)'
            ], 422);
        }

        $worker = Worker::where('PASS_NO', $input)->first();
        $today = now()->format('Ymd');

        if (!WorkerAttn::where('EMP_ID', $worker->EMP_ID)->where('ON_DTM', 'LIKE', $today . '%')->exists()) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => $worker->EMP_NM . '님은 출근기록이 없이 퇴근기록을 할 수 없습니다.'
            ], 422);
        }

        if (WorkerAttn::where('EMP_ID', $worker->EMP_ID)->where('ON_DTM', 'LIKE', $today . '%')->whereNotNull('OFF_DTM')->exists()) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => $worker->EMP_NM . '님은 오늘날짜 퇴근기록이 이미 되이있습니다.'
            ], 422);
        }

        $offDtm = now()->format('Ymdhis');
        WorkerAttn::where('EMP_ID', $worker->EMP_ID)->where('ON_DTM', 'LIKE', $today . '%')->update([
            'OFF_DTM' => $offDtm
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => $worker->EMP_NM . '님 퇴근기록이 되었습니다.',
            'time' => now()->parse($offDtm)->format('Y-m-d H:i'),
        ], 200);
    }

    public function getHaccpImpSchedule(Request $request)
    {
        $items = EdocFile::query();

        $sort = $request->input('sort', 'DOC_ID');
        $order = $request->input('order', 'ASC');

        $items = $items->where('PERIOD_CD', 'ED');
        $items = $items->where('USE_YN', 'Y');
        $items = $items->orderBy($sort, $order)->get();
        
        $periods = [
            ['label' => "월", 'value' => 0],
            ['label' => "화", 'value' => 1],
            ['label' => "수", 'value' => 2],
            ['label' => "목", 'value' => 3],
            ['label' => "금", 'value' => 4],
            ['label' => "토", 'value' => 5],
            ['label' => "일", 'value' => 6],
        ];

        $itemsParsed = [];
        foreach ($periods as $period) {
            $periodDocs = ["period" => $period['label'], "docs" => []];
            foreach ($items as $item) {
                // filter here later
                array_push($periodDocs["docs"], $item->DOC_NM);
            }

            array_push($itemsParsed, $periodDocs);
        }

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => $itemsParsed
        ]);
    }

    public function getCcpDocListDaily(Request $request)
    {
        $typeCd = 10;
        $periodCd = 'ED';
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetCcpDocResource::collection($this->queryEdocFile($typeCd, $periodCd))
        ]);
    }

    public function getCcpDocListWeek(Request $request)
    {
        $typeCd = 10;
        $periodCd = 'WK';
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetCcpDocResource::collection($this->queryEdocFile($typeCd, $periodCd))
        ]);
    }

    public function getCcpDocListMonth(Request $request)
    {
        $typeCd = 10;
        $periodCd = 'MM';
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetCcpDocResource::collection($this->queryEdocFile($typeCd, $periodCd))
        ]);
    }

    public function getCcpDocListQuarter(Request $request)
    {
        $typeCd = 10;
        $periodCd = 'QT';
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetCcpDocResource::collection($this->queryEdocFile($typeCd, $periodCd))
        ]);
    }

    public function getCcpDocListYear(Request $request)
    {
        $typeCd = 10;
        $periodCd = 'YR';
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetCcpDocResource::collection($this->queryEdocFile($typeCd, $periodCd))
        ]);
    }

    public function getHaccpDocListDaily(Request $request)
    {
        $typeCd = 20;
        $periodCd = 'ED';
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetCcpDocResource::collection($this->queryEdocFile($typeCd, $periodCd))
        ]);
    }

    public function getHaccpDocListWeek(Request $request)
    {
        $typeCd = 20;
        $periodCd = 'WK';
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetCcpDocResource::collection($this->queryEdocFile($typeCd, $periodCd))
        ]);
    }

    public function getHaccpDocListMonth(Request $request)
    {
        $typeCd = 20;
        $periodCd = 'MM';
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetCcpDocResource::collection($this->queryEdocFile($typeCd, $periodCd))
        ]);
    }

    public function getHaccpDocListQuarter(Request $request)
    {
        $typeCd = 20;
        $periodCd = 'QT';
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetCcpDocResource::collection($this->queryEdocFile($typeCd, $periodCd))
        ]);
    }

    public function getHaccpDocListYear(Request $request)
    {
        $typeCd = 20;
        $periodCd = 'YR';
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetCcpDocResource::collection($this->queryEdocFile($typeCd, $periodCd))
        ]);
    }

    private function queryEdocFile($typeCd, $periodCd)
    {
        $items = EdocFile::where('USE_YN', 'Y')
            ->where('TYPE_CD', $typeCd)
            ->where('PERIOD_CD', $periodCd)
            ->orderBy('DOC_ID', 'ASC')
            ->get();

        return $items;
    }

}
