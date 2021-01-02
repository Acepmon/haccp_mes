<?php

namespace App\Http\Controllers\API;

use App\ProcDtl;
use App\ProcDtlSub;
use App\Http\Resources\ProcDtlSubResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProcDtlSubController extends Controller
{
    public function index(Request $request)
    {
        $itemId = $request->input('item_id');
        $items = ProcDtlSub::where('ITEM_ID', $itemId)->get();
        $items2 = ProcDtl::where('ITEM_ID', $itemId)->get();
        $merged = $items->merge($items2);
        dd($merged);

        return ProcDtlSubResource::collection();
    }
}
