<?php

namespace App\Http\Controllers\APP;

use App\EdocFile;
use App\CommCd;
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
            default:
                return response()->json([
                    'status' => 'error',
                    'msg' => 'Request type incorrect'
                ]);
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

        return response()->json([
            'status' => 'success',
            'msg' => '',
            'data' => AppGetDocDailyListResource::collection($items)
        ]);
    }
}
