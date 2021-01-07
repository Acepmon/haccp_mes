<?php

namespace App\Http\Controllers\API;

use App\CcpData;
use App\Http\Controllers\Controller;
use App\Http\Resources\CcpDataResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HaccpMonitorController extends Controller
{
    // public function ccp_data(Request $request)
    // {
    //     $items = CcpData::query()->select('CCP_SEQ', 'DEVICE_ID', 'DATA', 'REG_DTM');

    //     $limit = $request->input('limit', 15);
    //     $sort = $request->input('sort', 'REG_DTM');
    //     $order = $request->input('order', 'DESC');
    //     $device_id = $request->input('device_id');
    //     $reg_dtm = $request->input('reg_dtm');
    //     $from = $request->input('from');

    //     if ($request->has('device_id')) {
    //         $items = $items->whereIn('DEVICE_ID', array_filter(explode(',', $device_id)));
    //     }

    //     if ($request->has('reg_dtm')) {
    //         $items = $items->where('REG_DTM', 'LIKE', $reg_dtm . '%');
    //     }

    //     if ($request->has('from')) {
    //         $items = $items->whereDate('REG_DTM', '>=', now()->parse($from)->format('YmdHis'));
    //     }

    //     if ($request->has('groupBy')) {
    //         $items = $items->groupBy('device_id');
    //     }

    //     if ($limit == -1) {
    //         $items = $items->orderBy($sort, $order)->get();
    //     } else {
    //         $items = $items->orderBy($sort, $order)->paginate($limit);
    //     }

    //     if ($request->has('stats')) {
    //         $stats = CcpData::select(DB::raw('MIN(CAST(DATA AS DECIMAL(10,2))) MIN, MAX(CAST(DATA AS DECIMAL(10,2))) MAX, AVG(CAST(DATA AS DECIMAL(10,2))) AVG'));

    //         if ($request->has('device_id')) {
    //             $stats = $stats->where('DEVICE_ID', $device_id);
    //         }

    //         if ($request->has('device_id')) {
    //             $stats = $stats->where('REG_DTM', 'LIKE', $reg_dtm . '%');
    //         }

    //         $stats = $stats->first();    
    //         $items = $items->map(function ($item) use ($stats) {
    //             return (object) [
    //                 'CCP_SEQ' => $item->CCP_SEQ,
    //                 'DEVICE_ID' => $item->DEVICE_ID,
    //                 'DATA' => $item->DATA,
    //                 'REG_DTM' => $item->REG_DTM,
    //                 'MIN' => $stats->MIN,
    //                 'MAX' => $stats->MAX,
    //                 'AVG' => $stats->AVG,
    //             ];
    //         });
    //     }

    //     return CcpDataResource::collection($items);
    // }

    public function ccp_data(Request $request)
    {
        $sort = $request->input('sort', 'DEVICE');
        $order = $request->input('order', 'ASC');
        $device_id = $request->input('device_id');
        $reg_dtm = $request->input('reg_dtm');

        $items = DB::connection('haccp_server')
            ->table('CCP_DATA')
            ->select(
                'DEVICE_ID AS DEVICE', 
                DB::raw('(SELECT CAST(DATA AS DECIMAL(10,2)) FROM CCP_DATA B WHERE B.DEVICE_ID = DEVICE AND B.REG_DTM LIKE "'.$reg_dtm.'%" ORDER BY B.REG_DTM DESC LIMIT 1) AS DATA'), 
                DB::raw('(SELECT REG_DTM FROM CCP_DATA B WHERE B.DEVICE_ID = DEVICE AND B.REG_DTM LIKE "'.$reg_dtm.'%" ORDER BY B.REG_DTM DESC LIMIT 1) AS REG_DTM'), 
                DB::raw('MIN(CAST(DATA AS DECIMAL(10,2))) AS MIN'), 
                DB::raw('MAX(CAST(DATA AS DECIMAL(10,2))) AS MAX'), 
                DB::raw('AVG(CAST(DATA AS DECIMAL(10,2))) AS AVG')
            )
            ->whereIn('DEVICE_ID', array_filter(explode(',', $device_id)))
            ->groupBy('DEVICE_ID')
            ->havingRaw('MIN(CAST(DATA AS DECIMAL(10,2)))')
            ->havingRaw('MAX(CAST(DATA AS DECIMAL(10,2)))')
            ->havingRaw('AVG(CAST(DATA AS DECIMAL(10,2)))')
            ->orderBy($sort, $order)
            ->get();

        return CcpDataResource::collection($items);
    }

    public function ccp_data_details(Request $request, $deviceId)
    {
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'ASC');
        $from = $request->input('from');
        $reg_dtm = $request->input('reg_dtm');
        $limit = $request->input('limit', 15);

        $items = CcpData::where('DEVICE_ID', $deviceId)->select('DEVICE_ID AS DEVICE', 'DATA', 'REG_DTM');

        if ($request->has('from')) {
            $from = now()->parse($from)->format('YmdHis');
            $items = $items->whereRaw('CAST(REG_DTM AS SIGNED) >= ' . intval($from));
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
}
