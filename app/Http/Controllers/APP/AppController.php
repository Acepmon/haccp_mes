<?php

namespace App\Http\Controllers\APP;

use App\CcpCdInfo;
use App\CcpData;
use App\CcpEscYn;
use App\CcpEscData;
use App\JobOrd;
use App\JobOrdDtl;
use App\JobOrdDtlWork;
use App\EdocFile;
use App\EdocFileHaccp;
use App\CommCd;
use App\Worker;
use App\WorkerAttn;
use App\Http\Resources\AppGetDocDailyListResource;
use App\Http\Resources\AppGetCcpDocResource;
use App\Http\Resources\AppChecklistDetailResource;
use App\Http\Resources\AppGetDocListDetailResource;
use App\Http\Resources\AppGetApprovalDocResource;
use App\Http\Resources\AppGetDayProductionListResource;
use App\Http\Resources\AppGetDayProductionListDetailResource;
use App\Http\Resources\AppGetRawMaterialForwardResource;
use App\Http\Resources\AppGetRawMaterialForwardDetailResource;
use App\Http\Resources\AppGetProcessStatusResource;
use App\Http\Resources\AppGetProcessStatusDetailResource;
use App\Http\Resources\AppGetCcpDivisionResource;
use App\Http\Resources\AppGetCcpRequestInfoResource;
use App\Http\Resources\AppGetAllCcpMonitoringResource;
use App\Http\Resources\AppGetCcpMonitoringDetailResource;
use App\Http\Resources\AppGetAllCcpBreakawayResource;
use App\Http\Resources\AppGetCcpBreakawayInfoResource;
use App\Http\Resources\AppVersionResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            case 'apply_attendance_yes': return $this->applyAttendanceYes($request);
            case 'apply_attendance_no': return $this->applyAttendanceNo($request);
            case 'apply_leave_work_yes': return $this->applyLeaveWorkYes($request);
            case 'apply_leave_work_no': return $this->applyLeaveWorkNo($request);
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
            case 'get_checklist_detail': return $this->getChecklistDetail($request);
            case 'write_checklist_detail_temp': return $this->writeChecklistDetailTemp($request);
            case 'write_checklist_detail_complete': return $this->writeChecklistDetailComplete($request);
            case 'get_doc_list_detail': return $this->getDocListDetail($request);
            case 'search_doc_list_date': return $this->searchDocListDate($request);
            case 'search_doc_list_state_progress': return $this->searchDocListStateProgress($request);
            case 'search_doc_list_state_request': return $this->searchDocListStateRequest($request);
            case 'search_doc_list_state_completion': return $this->searchDocListStateCompletion($request);
            case 'get_approval_list': return $this->getApprovalList($request);
            case 'get_approval_doc': return $this->getApprovalDoc($request);
            case 'write_approval_doc': return $this->writeApprovalDoc($request);
            case 'get_day_production_list': return $this->getDayProductionList($request);
            case 'get_day_production_list_detail': return $this->getDayProductionListDetail($request);
            case 'get_raw_material_forwarding': return $this->getRawMaterialForwarding($request);
            case 'get_raw_material_forwarding_detail': return $this->getRawMaterialForwardingDetail($request);
            case 'get_process_status': return $this->getProcessStatus($request);
            case 'get_process_status_detail': return $this->getProcessStatusDetail($request);
            case 'write_process_status_start': return $this->writeProcessStatusStart($request);
            case 'write_process_status_end': return $this->writeProcessStatusEnd($request);
            case 'get_ccp_division': return $this->getCcpDivision($request);
            case 'get_ccp_request_info': return $this->getCcpRequestInfo($request);
            case 'write_ccp_info': return $this->writeCcpInfo($request);
            case 'get_all_ccp_monitoring': return $this->getAllCcpMonitoring($request);
            case 'get_all_ccp_breakaway': return $this->getAllCcpBreakaway($request);
            case 'get_ccp_breakaway_info': return $this->getCcpBreakawayInfo($request);
            case 'write_ccp_breakaway': return $this->writeCcpBreakaway($request);
            case 'get_ccp_monitoring_detail': return $this->getCcpMonitoringDetail($request);
            case 'apply_ccp_monitoring_exception_on': return $this->applyCcpMonitoringExceptionOn($request);
            case 'apply_ccp_monitoring_exception_off': return $this->applyCcpMonitoringExceptionOff($request);
            default:
                return $this->jsonResponse([
                    'request_type' => $request->input('request_type'),
                    'status' => 'error',
                    'msg' => 'Request type incorrect'
                ], 422);
        }
    }

    public function version(Request $request)
    {
        $appVer = $this->getAppVer();

        return $this->jsonResponse([
            // 'os' => $appVer->os,
            // 'app_id' => $appVer->app_id,
            'version' => $appVer->version,
        ]);
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
                'msg' => $worker->EMP_NM . '님은 오늘날짜 출근기록이 이미 있습니다.'
            ], 422);
        }

        // $workerAttn = WorkerAttn::create([
        //     'EMP_ID' => $worker->EMP_ID,
        //     'ON_DTM' => now()->format('Ymdhis'),
        // ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => $worker->EMP_NM . '님 본인 출근 기록이 맞습니까?.',
            // 'time' => now()->parse($workerAttn->ON_DTM)->format('Y-m-d H:i'),
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
                'msg' => $worker->EMP_NM . '님은 오늘날짜 퇴근기록이 이미 있습니다.'
            ], 422);
        }

        // $offDtm = now()->format('Ymdhis');
        // WorkerAttn::where('EMP_ID', $worker->EMP_ID)->where('ON_DTM', 'LIKE', $today . '%')->update([
        //     'OFF_DTM' => $offDtm
        // ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => $worker->EMP_NM . '님 본인 퇴근기록이 맞습니까?',
            //'time' => now()->parse($offDtm)->format('Y-m-d H:i'),
        ], 200);
    }

    public function applyAttendanceYes(Request $request)
    {
        $request->validate([
            'input' => 'required|numeric'
        ]);

        $input = $request->input('input');

        $worker = Worker::where('PASS_NO', $input)->first();
        $today = now()->format('Ymd');

        $workerAttn = WorkerAttn::create([
            'EMP_ID' => $worker->EMP_ID,
            'ON_DTM' => now()->format('Ymdhis'),
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => $worker->EMP_NM . '님 출근 처리되었습니다.',
            'time' => now()->parse($workerAttn->ON_DTM)->format('Y-m-d H:i'),
        ], 200);
    }

    public function applyAttendanceNo(Request $request)
    {
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '취소되었습니다.',
        ], 200);
    }

    public function applyLeaveWorkYes(Request $request)
    {
        $request->validate([
            'input' => 'required|numeric'
        ]);

        $input = $request->input('input');

        $worker = Worker::where('PASS_NO', $input)->first();
        $today = now()->format('Ymd');

        $offDtm = now()->format('Ymdhis');
        WorkerAttn::where('EMP_ID', $worker->EMP_ID)->where('ON_DTM', 'LIKE', $today . '%')->update([
            'OFF_DTM' => $offDtm
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => $worker->EMP_NM . '님 퇴근 처리되었습니다.',
            'time' => now()->parse($offDtm)->format('Y-m-d H:i'),
        ], 200);
    }

    public function applyLeaveWorkNo(Request $request)
    {
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '취소되었습니다.',
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

    public function getChecklistDetail(Request $request)
    {
        $docIdx = $request->input('doc_idx');
        $item = EdocFileHaccp::where('HACCP_SEQ', $docIdx);

        // if ($request->has('doc_approval_idx')) {
        //     $docApprovalIdx = $request->input('doc_approval_idx');
        //     $item = $item->where('APP_ID', $docApprovalIdx);
        // }

        $item = $item->first();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'document' => new AppChecklistDetailResource($item)
        ]);
    }

    public function writeChecklistDetailTemp(Request $request)
    {
        $request->validate([
            'doc_idx' => 'required',
            'appdata' => 'required',
            'doc_approval_idx' => 'nullable',
        ]);

        $docIdx = $request->input('doc_idx');
        $appdata = $request->input('appdata');
        $docApprovalIdx = $request->input('doc_approval_idx');

        $item = $this->insertEdocFileHaccp($docIdx, $appdata, $docApprovalIdx, 'TEMP');

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => 'Successfully inserted haccp doc file temp',
        ]);
    }

    public function writeChecklistDetailComplete(Request $request)
    {
        $request->validate([
            'doc_idx' => 'required',
            'appdata' => 'required',
            'doc_approval_idx' => 'required',
        ]);

        $docIdx = $request->input('doc_idx');
        $appdata = $request->input('appdata');
        $docApprovalIdx = $request->input('doc_approval_idx');

        $item = $this->insertEdocFileHaccp($docIdx, $appdata, $docApprovalIdx, '10');

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => 'Successfully inserted haccp doc file complete',
        ]);
    }

    public function getDocListDetail(Request $request)
    {
        $idx = $request->input('idx');

        $items = EdocFileHaccp::where('DOC_ID', $idx)
            ->orderBy('WORK_DTM', 'DESC')
            ->with(['apr'])
            ->get();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'data' => AppGetDocListDetailResource::collection($items)
        ]);
    }

    public function searchDocListDate(Request $request)
    {
        $idx = $request->input('idx');
        $search = $request->input('search');
        $search = now()->parse($search)->format('Ymd');

        $items = EdocFileHaccp::where('DOC_ID', $idx)
            ->where('WORK_DTM', 'LIKE', $search . '%')
            ->orderBy('WORK_DTM', 'DESC')
            ->with(['apr'])
            ->get();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'data' => AppGetDocListDetailResource::collection($items)
        ]);
    }

    public function searchDocListStateProgress(Request $request)
    {
        $idx = $request->input('idx');

        $items = EdocFileHaccp::where('DOC_ID', $idx)
            ->where('APR_CD', 'TEMP')
            ->orderBy('WORK_DTM', 'DESC')
            ->with(['apr'])
            ->get();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'data' => AppGetDocListDetailResource::collection($items)
        ]);
    }

    public function searchDocListStateRequest(Request $request)
    {
        $idx = $request->input('idx');

        $items = EdocFileHaccp::where('DOC_ID', $idx)
            ->where('APR_CD', '10')
            ->orderBy('WORK_DTM', 'DESC')
            ->with(['apr'])
            ->get();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'data' => AppGetDocListDetailResource::collection($items)
        ]);
    }

    public function searchDocListStateCompletion(Request $request)
    {
        $idx = $request->input('idx');

        $items = EdocFileHaccp::where('DOC_ID', $idx)
            ->where('APR_CD', '20')
            ->orderBy('WORK_DTM', 'DESC')
            ->with(['apr'])
            ->get();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'data' => AppGetDocListDetailResource::collection($items)
        ]);
    }

    public function getApprovalList(Request $request)
    {
        $search = $request->input('search');
        $search = now()->parse($search)->format('Ymd');
        $search = $search . '000000';

        $items = EdocFileHaccp::query()
            ->where('APR_CD', '10')
            ->whereRaw('CAST(WORK_DTM AS SIGNED) >= ' . intval($search))
            ->orderBy('WORK_DTM', 'DESC')
            ->with(['apr'])
            ->get();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'data' => AppGetDocListDetailResource::collection($items)
        ]);
    }

    public function getApprovalDoc(Request $request)
    {
        $docIdx = $request->input('doc_idx');

        $item = EdocFileHaccp::where('HACCP_SEQ', $docIdx)->where('APR_CD', '10');

        if ($request->has('doc_approval_idx')) {
            $docApprovalIdx = $request->input('doc_approval_idx');
            $item = $item->where('APP_ID', $docApprovalIdx);
        }

        $item = $item->first();

        if ($item == null) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => 'Document not found',
            ], 422);
        }

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => new AppGetApprovalDocResource($item)
        ]);
    }

    public function writeApprovalDoc(Request $request)
    {
        $haccpSeq = $request->input('haccp_seq');
        $appData = $request->input('app_data');
        $docApprovalIdx = $request->input('doc_approval_idx');

        $item = EdocFileHaccp::where('HACCP_SEQ', $haccpSeq)->where('APR_CD', '10')->first();

        if ($item == null) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => 'Document not found',
            ], 422);
        }

        $item->update([
            'APR_CD' => '20',
            'APP_DATA' => $appData,
            'APP_ID' => $docApprovalIdx,
            'APP_DTM' => now()->format('YmdHis'),
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => 'Successfully approved'
        ]);
    }

    public function getDayProductionList(Request $request)
    {
        $items = JobOrd::get();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'data' => AppGetDayProductionListResource::collection($items)
        ]);
    }

    public function getDayProductionListDetail(Request $request)
    {
        $request->validate([
            'idx' => 'required',
        ]);

        $idx = $request->input('idx');
        $items = JobOrdDtl::where('JOB_NO', $idx)->get();
        $items = $items->map(function ($item) {
            $jobOrdDtlWorkers = JobOrdDtlWork::where('JOB_NO', $item->JOB_NO)
                ->where('ITEM_ID', $item->ITEM_ID)
                ->where('SEQ_NO', $item->SEQ_NO)
                ->with(['worker'])
                ->get();

            $empNms = [];
            foreach ($jobOrdDtlWorkers as $key => $jobOrdDtlWorker) {
                array_push($empNms, $jobOrdDtlWorker->worker->EMP_NM);
            }

            $item->EMP_NM = implode(',', $empNms);
            return $item;
        });

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'idx' => $idx,
            'data' => AppGetDayProductionListDetailResource::collection($items)
        ]);
    }

    public function getRawMaterialForwarding(Request $request)
    {
        $items = JobOrd::get();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'data' => AppGetRawMaterialForwardResource::collection($items)
        ]);
    }

    public function getRawMaterialForwardingDetail(Request $request)
    {
        $request->validate([
            'idx' => 'required',
        ]);

        $idx = $request->input('idx');
        $items = JobOrd::where('JOB_NO', $idx)->get();
        $details = $this->queryJobOrdBomDetails($items);
        $merged = [];
        foreach ($details as $detail) {
            $merged = array_merge($merged, $detail['subdetails']->toArray());
        }

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => count($merged),
            'idx' => $idx,
            'data' => AppGetRawMaterialForwardDetailResource::collection($merged)
        ]);
    }

    public function getProcessStatus(Request $request)
    {
        $items = JobOrd::get();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'data' => AppGetProcessStatusResource::collection($items)
        ]);
    }

    public function getProcessStatusDetail(Request $request)
    {
        $request->validate([
            'idx' => 'required',
        ]);

        $idx = $request->input('idx');
        $items = JobOrdDtl::where('JOB_NO', $idx)->get();
        $items = $items->map(function ($item) {
            $jobOrdDtlWorkers = JobOrdDtlWork::where('JOB_NO', $item->JOB_NO)
                ->where('ITEM_ID', $item->ITEM_ID)
                ->where('SEQ_NO', $item->SEQ_NO)
                ->with(['worker'])
                ->get();

            $empNms = [];
            foreach ($jobOrdDtlWorkers as $key => $jobOrdDtlWorker) {
                array_push($empNms, $jobOrdDtlWorker->worker->EMP_NM);
            }

            $item->EMP_NM = implode(',', $empNms);
            return $item;
        });

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'rows' => $items->count(),
            'idx' => $idx,
            'data' => AppGetProcessStatusDetailResource::collection($items)
        ]);
    }

    public function writeProcessStatusStart(Request $request)
    {
        $request->validate([
            'idx' => 'required',
            'process_idx' => 'required',
        ]);

        $idx = $request->input('idx');
        $process_idx = $request->input('process_idx');

        $item = JobOrdDtl::where('JOB_NO', $idx)->where('SEQ_NO', $process_idx)->first();

        if ($item == null) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => 'Process not found',
            ], 422);
        }

        $item->update([
            'SRT_DTM' => now()->format('YmdHis')
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => 'Successfully updated process',
        ]);
    }

    public function writeProcessStatusEnd(Request $request)
    {
        $request->validate([
            'idx' => 'required',
            'process_idx' => 'required',
        ]);

        $idx = $request->input('idx');
        $process_idx = $request->input('process_idx');

        $item = JobOrdDtl::where('JOB_NO', $idx)->where('SEQ_NO', $process_idx)->first();

        if ($item == null) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => 'Process not found',
            ], 422);
        }

        $item->update([
            'END_DTM' => now()->format('YmdHis')
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => 'Successfully updated process',
        ]);
    }

    public function getCcpDivision(Request $request)
    {
        $request->validate([
            'idx' => 'required',
            'process_idx' => 'required'
        ]);
        $idx = $request->input('idx');
        $processIdx = $request->input('process_idx');
        $items = CcpCdInfo::get();

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'idx' => $idx,
            'process_idx' => $processIdx,
            'data' => AppGetCcpDivisionResource::collection($items),
            'devices' => CommCd::where('COMM1_CD', 'C00')->whereNotIn('COMM2_CD', ['$$'])->get()->map(function ($device) {
                return [
                    'device_cd' => $device->COMM2_CD,
                    'device_nm' => $device->COMM2_NM,
                ];
            })
        ]);
    }

    public function getCcpRequestInfo(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'device_id' => 'required',
            'idx' => 'required',
            'process_idx' => 'required'
        ]);
        $type = $request->input('type');
        $deviceId = $request->input('device_id');
        $idx = $request->input('idx');
        $processIdx = $request->input('process_idx');

        $item = CcpData::where('DEVICE_ID', $deviceId)->orderBy('REG_DTM', 'DESC')->first();

        if ($item == null) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => 'Ccp data not found',
            ], 422);
        }

        $item->idx = $idx;
        $item->processIdx = $processIdx;

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => new AppGetCcpRequestInfoResource($item)
        ]);
    }

    public function writeCcpInfo(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'device_id' => 'required',
            'idx' => 'required',
            'process_idx' => 'required',
            'time' => 'required',
            'temperature' => 'required',
            'heating_time' => 'required',
            'poom_temperature' => 'required',
        ]);
        $type = $request->input('type');
        $deviceId = $request->input('device_id');
        $idx = $request->input('idx');
        $processIdx = $request->input('process_idx');
        $time = $request->input('time');
        $temp = $request->input('temperature');
        $heat = $request->input('heating_time');
        $poom = $request->input('poom_temperature');

        $item = JobOrdDtl::where('JOB_NO', $idx)->where('SEQ_NO', $processIdx)->first();

        if ($item == null) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => 'Job Order detail not found',
            ], 422);
        }

        $item->update([
            'CHK1_DTM' => $time,
            'CHK_TEMP' => intval($temp),
            'CHK2_TIME' => intval($heat),
            'CHK2_TEMP' => intval($poom),
            'CCP_CD' => $type,
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => 'Successfully updated job order detail',
        ]);
    }

    public function getAllCcpMonitoring(Request $request)
    {
        $deviceCds = CommCd::where('COMM1_CD', 'C00')->whereNotIn('COMM2_CD', ['$$'])->get();
        $device_id = implode(',', $deviceCds->pluck('COMM2_CD')->toArray());
        $items = DB::connection('haccp_server')
            ->table('CCP_DATA')
            ->select(
                'DEVICE_ID AS DEVICE', 
                DB::raw('(SELECT CAST(DATA AS DECIMAL(10,2)) FROM CCP_DATA B WHERE B.DEVICE_ID = DEVICE ORDER BY B.REG_DTM DESC LIMIT 1) AS DATA'), 
                DB::raw('(SELECT REG_DTM FROM CCP_DATA B WHERE B.DEVICE_ID = DEVICE ORDER BY B.REG_DTM DESC LIMIT 1) AS REG_DTM'), 
            )
            ->whereIn('DEVICE_ID', array_filter(explode(',', $device_id)))
            ->groupBy('DEVICE_ID')
            ->orderBy('DEVICE', 'ASC')
            ->get();
        
        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetAllCcpMonitoringResource::collection($items),
        ]);
    }

    public function getAllCcpBreakaway(Request $request)
    {
        $items = CcpEscData::all();
        $items = $items->map(function ($item) {
            return [
                'device_nm' => CommCd::where('COMM1_CD', 'C00')->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_CD', $item->DEVICE_ID)->value('COMM2_NM'),
                'idx' => $item->DEVICE_ID . '-' . $item->SRC_CD . '-' . $item->SRT_DTM,
                'srt_dtm' => now()->parse($item->SRT_DTM)->format('Y-m-d'),
                'esc_data' => $item->ESC_DATA . $this->unit($item->DEVICE_ID),
                'status' => !empty($item->REASON) ? 'YES' : 'NO'
            ];
        });
        $items = $items->groupBy('srt_dtm');

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => AppGetAllCcpBreakawayResource::collection($items),
        ]);
    }

    public function getCcpBreakawayInfo(Request $request)
    {
        $request->validate([
            'idx' => 'required'
        ]);
        $idx = $request->input('idx');
        $idx = explode('-', $idx);

        $deviceId = array_key_exists(0, $idx) ? $idx[0] : null;
        $srcCd = array_key_exists(1, $idx) ? $idx[1] : null;
        $srtDtm = array_key_exists(2, $idx) ? $idx[2] : null;

        $item = CcpEscData::where('DEVICE_ID', $deviceId)->where('SRC_CD', $srcCd)->where('SRT_DTM', $srtDtm)->first();
        if ($item == null) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => '해당자료가 없습니다.',
            ], 422);
        }

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'data' => new AppGetCcpBreakawayInfoResource($item),
        ]);
    }

    public function writeCcpBreakaway(Request $request)
    {
        $request->validate([
            'idx' => 'required',
            'cause' => 'nullable',
            'action' => 'nullable'
        ]);

        $idx = $request->input('idx');
        $idx = explode('-', $idx);

        $deviceId = array_key_exists(0, $idx) ? $idx[0] : null;
        $srcCd = array_key_exists(1, $idx) ? $idx[1] : null;
        $srtDtm = array_key_exists(2, $idx) ? $idx[2] : null;

        $item = CcpEscData::where('DEVICE_ID', $deviceId)->where('SRC_CD', $srcCd)->where('SRT_DTM', $srtDtm)->first();
        if ($item == null) {
            return $this->jsonResponse([
                'request_type' => $request->input('request_type'),
                'status' => 'error',
                'msg' => '해당자료가 없습니다.',
            ], 422);
        }

        $item->update([
            'REASON' => '발생원인: ' . $request->input('cause') . '조치결과: ' . $request->input('action')
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => 'Success',
        ]);
    }

    public function getCcpMonitoringDetail(Request $request)
    {
        $request->validate([
            'idx' => 'required'
        ]);
        $idx = $request->input('idx');
        $idxArr = explode('-', $idx);

        $deviceId = array_key_exists(0, $idxArr) ? $idxArr[0] : null;
        $srcCd = array_key_exists(1, $idxArr) ? $idxArr[1] : null;
        $srtDtm = array_key_exists(2, $idxArr) ? $idxArr[2] : null;

        $items = CcpData::select('DEVICE_ID', 'DATA', 'REG_DTM')->where('DEVICE_ID', $deviceId);
        $from = now()->subHours(24)->format('YmdHis');
        $items = $items->whereRaw('CAST(REG_DTM AS SIGNED) >= ' . intval($from));
        $items = $items->orderBy('REG_DTM', 'ASC')->get();
        $useYn = CcpEscYn::where('DEVICE_ID', $deviceId)->value('USE_YN');

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => '',
            'idx' => $idx,
            'exception' => !empty($useYn) ? $useYn : null,
            'current_dtm' => $items->last()->REG_DTM,
            'current_data' => $items->last()->DATA . $this->unit($deviceId),
            'min' => $items->min('DATA') . $this->unit($deviceId),
            'max' => $items->max('DATA') . $this->unit($deviceId),
            'data' => AppGetCcpMonitoringDetailResource::collection($items)
        ]);
    }

    public function applyCcpMonitoringExceptionOn(Request $request)
    {
        $request->validate([
            'idx' => 'required'
        ]);
        $idx = $request->input('idx');
        $idxArr = explode('-', $idx);

        $deviceId = array_key_exists(0, $idxArr) ? $idxArr[0] : null;
        $srcCd = array_key_exists(1, $idxArr) ? $idxArr[1] : null;
        $srtDtm = array_key_exists(2, $idxArr) ? $idxArr[2] : null;

        CcpEscYn::updateOrInsert(
        [
            'DEVICE_ID' => $deviceId,
        ],
        [
            'USE_YN' => 'Y'
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => 'Success',
        ]);
    }

    public function applyCcpMonitoringExceptionOff(Request $request)
    {
        $request->validate([
            'idx' => 'required'
        ]);
        $idx = $request->input('idx');
        $idxArr = explode('-', $idx);

        $deviceId = array_key_exists(0, $idxArr) ? $idxArr[0] : null;
        $srcCd = array_key_exists(1, $idxArr) ? $idxArr[1] : null;
        $srtDtm = array_key_exists(2, $idxArr) ? $idxArr[2] : null;

        CcpEscYn::updateOrInsert(
        [
            'DEVICE_ID' => $deviceId,
        ],
        [
            'USE_YN' => 'N'
        ]);

        return $this->jsonResponse([
            'request_type' => $request->input('request_type'),
            'status' => 'success',
            'msg' => 'Success',
        ]);
    }

    private function unit($device)
    {
        if (in_array($device, ['CHUMI1', 'RHUMI1', 'SIRIH1'])) {
            return '%';
        }
        return '℃';
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

    private function insertEdocFileHaccp($docIdx, $appdata, $docApprovalIdx, $aprCd)
    {
        $edocFile = EdocFile::where('DOC_ID', $docIdx)->first();
        $item = EdocFileHaccp::create([
            'DOC_ID' => $docIdx,
            'DOC_NM' => $edocFile->DOC_NM,
            'DOC_HTML' => $edocFile->DOC_HTML,
            'APP_DATA' => $appdata,
            'APR_CD' => $aprCd,
            'WORK_ID' => $docApprovalIdx,
            'WORK_DTM' => now()->format('Ymdhis'),
            'USE_YN' => 'Y'
        ]);

        return $item;
    }

    private function queryJobOrdBomDetails($items)
    {
        $details = [];

        foreach ($items as $jobOrd) {
            $subdetails = DB::table('JOB_ORD_BOM')
                ->select('JOB_ORD_BOM.ITEM2_ID AS ITEM_ID', 'JOB_ORD_BOM.ITEM2_NM AS ITEM_NM', DB::raw('(JOB_ORD.ORD_QTY * JOB_ORD_BOM.USE_QTY / JOB_ORD_BOM.PROD_QTY) AS REQ'))
                ->join('JOB_ORD', 'JOB_ORD_BOM.ITEM_ID', '=', 'JOB_ORD.ITEM_ID')
                ->where('JOB_ORD_BOM.ITEM_ID', $jobOrd->ITEM_ID)
                ->get();

            $sum = $subdetails->sum('REQ');

            array_push($details, [
                'reqSum' => number_format($sum),
                'ratio' => 100,
                'origin' => '',
                'item_id' => $jobOrd->ITEM_ID,
                'subdetails' => $subdetails->map(function ($subdetail) use ($sum) {
                    $ratio = 100 / $sum * intval($subdetail->REQ);
                    return [
                        'item_id' => $subdetail->ITEM_ID,
                        'item_nm' => $subdetail->ITEM_NM,
                        'req' => number_format(intval($subdetail->REQ)),
                        'ratio' => number_format((float) $ratio, 2, '.', ''),
                        'origin' => ''
                    ];
                })
            ]);
        }

        return $details;
    }

    private function getAppVer()
    {
        if (!Storage::exists('app_version.json')) {
            Storage::put('app_version.json', '{"os": "AOS","app_id": "com.bokmansa.imasic","version": "1.0.0"}');
        }

        $content = file_get_contents(storage_path('app/app_version.json'));
        $json = json_decode($content);
        return $json;
    }

    private function setAppVer($os, $appId, $version)
    {
        Storage::put('app_version.json', json_encode([
            'os' => $os,
            'app_id' => $appId,
            'version' => $version,
        ]));

        return $this->getAppVer();
    }

}
