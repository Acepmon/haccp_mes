<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\UnifiedProcImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ProcUnifiedController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        DB::table('PROC_SRC')->truncate();
        DB::table('PROC_DTL')->truncate();
        DB::table('PROC_DTL_SUB')->truncate();

        $result = Excel::import(new UnifiedProcImport(), $request->file('file'));

        return response()->json([
            'success' => true,
            'message' => __('Successfully imported')
        ]);
    }
}
