<?php

namespace App\Http\Controllers\API;

use App\CcpData;
use App\Http\Controllers\Controller;
use App\Http\Resources\CcpDataResource;
use Illuminate\Http\Request;

class HaccpMonitorController extends Controller
{
    public function ccp_data(Request $request)
    {
        $items = CcpData::paginate();

        return CcpDataResource::collection($items);
    }
}
