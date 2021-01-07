<?php

namespace App\Http\Controllers\API;

use App\CcpData;
use App\Http\Controllers\Controller;
use App\Http\Resources\CcpDataResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HaccpMonitorController extends Controller
{
    public function ccp_data(Request $request)
    {
        $items = CcpData::query();

        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'DESC');
        $device_id = $request->input('device_id');
        $reg_dtm = $request->input('reg_dtm');
        $from = $request->input('from');

        if ($request->has('device_id')) {
            $items = $items->where('DEVICE_ID', $device_id);
        }

        if ($request->has('reg_dtm')) {
            $items = $items->where('REG_DTM', 'LIKE', $reg_dtm . '%');
        }

        if ($request->has('from')) {
            $items = $items->whereDate('REG_DTM', '>=', now()->parse($from)->format('YmdHis'));
        }

        if ($limit == -1) {
            $items = $items->orderBy($sort, $order)->get();
        } else {
            $items = $items->orderBy($sort, $order)->paginate($limit);
        }

        if ($request->has('stats')) {
            $stats = CcpData::select(DB::raw('MIN(DATA) MIN, MAX(DATA) MAX, AVG(DATA) AVG'));

            if ($request->has('device_id')) {
                $stats = $stats->where('DEVICE_ID', $device_id);
            }

            if ($request->has('device_id')) {
                $stats = $stats->where('REG_DTM', 'LIKE', $reg_dtm . '%');
            }

            $stats = $stats->first();    
            $items = $items->map(function ($item) use ($stats) {
                return (object) [
                    'CCP_SEQ' => $item->CCP_SEQ,
                    'DEVICE_ID' => $item->DEVICE_ID,
                    'DATA' => $item->DATA,
                    'REG_DTM' => $item->REG_DTM,
                    'MIN' => $stats->MIN,
                    'MAX' => $stats->MAX,
                    'AVG' => $stats->AVG,
                ];
            });
        }

        return CcpDataResource::collection($items);
    }
}
