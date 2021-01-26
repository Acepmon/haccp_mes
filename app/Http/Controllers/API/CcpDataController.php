<?php

namespace App\Http\Controllers\API;

use App\CcpData;
use App\CcpEscData;
use App\CcpLimit;
use App\CommCd;
use App\Exports\CcpDataExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\CcpDataResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CcpDataController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'DESC');
        $limit = $request->input('limit', 15);

        $items = CcpData::select('DEVICE_ID AS DEVICE', 'DATA', 'REG_DTM');

        if ($request->has('device_id') && !empty($request->input('device_id'))) {
            $items = $items->where('DEVICE_ID', $request->input('device_id'));
        }

        if ($request->has('from') && !empty($request->input('from'))) {
            $from = now()->parse($request->input('from'))->format('YmdHis');
            $items = $items->whereRaw('CAST(REG_DTM AS SIGNED) >= ' . intval($from));
        }

        if ($request->has('to') && !empty($request->input('to'))) {
            $to = now()->parse($request->input('to') . '235959')->format('YmdHis');
            $items = $items->whereRaw('CAST(REG_DTM AS SIGNED) <= ' . intval($to));
        }

        if ($request->has('reg_dtm') && !empty($request->input('reg_dtm'))) {
            $items = $items->where('REG_DTM', 'LIKE', $request->input('reg_dtm') . '%');
        }

        if ($limit == -1) {
            $items = $items->orderBy($sort, $order)->get();
        } else {
            $items = $items->orderBy($sort, $order)->paginate($limit);
        }

        return CcpDataResource::collection($items);
    }

    public function dashboard(Request $request)
    {
        $deviceCds = CommCd::where('COMM1_CD', 'C00')->whereNotIn('COMM2_CD', ['$$'])->get();

        $sort = $request->input('sort', 'DEVICE');
        $order = $request->input('order', 'ASC');
        $device_id = $request->input('device_id', implode(',', $deviceCds->pluck('COMM2_CD')->toArray()));
        $reg_dtm = $request->input('reg_dtm');
        $from = $request->input('from');

        $items = DB::connection('haccp_server')
            ->table('CCP_DATA')
            ->select(
                'DEVICE_ID AS DEVICE', 
                DB::raw('(SELECT CAST(DATA AS DECIMAL(10,2)) FROM CCP_DATA B WHERE B.DEVICE_ID = DEVICE ORDER BY B.REG_DTM DESC LIMIT 1) AS DATA'), 
                DB::raw('(SELECT REG_DTM FROM CCP_DATA B WHERE B.DEVICE_ID = DEVICE ORDER BY B.REG_DTM DESC LIMIT 1) AS REG_DTM'), 
                DB::raw('(SELECT MIN(CAST(B.DATA AS DECIMAL(10,2))) FROM CCP_DATA B WHERE B.DEVICE_ID = DEVICE)AS MIN'), 
                DB::raw('(SELECT MAX(CAST(B.DATA AS DECIMAL(10,2))) FROM CCP_DATA B WHERE B.DEVICE_ID = DEVICE) AS MAX'), 
                DB::raw('(SELECT AVG(CAST(B.DATA AS DECIMAL(10,2))) FROM CCP_DATA B WHERE B.DEVICE_ID = DEVICE) AS AVG'), 
            )
            ->whereIn('DEVICE_ID', array_filter(explode(',', $device_id)))
            ->groupBy('DEVICE_ID')
            ->orderBy($sort, $order)
            ->get();

        return CcpDataResource::collection($items);
    }

    public function details(Request $request, $deviceId)
    {
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'ASC');
        $from = $request->input('from');
        $to = $request->input('to');
        $reg_dtm = $request->input('reg_dtm');
        $limit = $request->input('limit', 15);

        $items = CcpData::where('DEVICE_ID', $deviceId)->select('DEVICE_ID AS DEVICE', 'DATA', 'REG_DTM');

        if ($request->has('from')) {
            $from = now()->parse($from)->format('YmdHis');
            $items = $items->whereRaw('CAST(REG_DTM AS SIGNED) >= ' . intval($from));
        }

        if ($request->has('to')) {
            $to = now()->parse($to)->format('YmdHis');
            $items = $items->whereRaw('CAST(REG_DTM AS SIGNED) <= ' . intval($to));
        }

        if ($request->has('reg_dtm')) {
            $items = $items->where('REG_DTM', 'LIKE', $reg_dtm . '%');
        }

        if ($limit == -1) {
            $items = $items->orderBy($sort, $order)->get();
        } else {
            $items = $items->orderBy($sort, $order)->paginate($limit);
        }

        return CcpDataResource::collection($items); 
    }

    public function export(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $deviceId = $request->input('device_id');

        return Excel::download(new CcpDataExport($from, $to, $deviceId), 'CCP-DATA-' . now()->format('Y-m-d') . '.xlsx');
    }
}
