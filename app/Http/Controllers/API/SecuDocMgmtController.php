<?php

namespace App\Http\Controllers\API;

use App\AttFile;
use App\Exports\SecuDocMgmtExport;
use App\Http\Controllers\Controller;
use App\SecuDocMgmt;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SecuDocMgmtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download(Request $request)
    {
        return Excel::download(new SecuDocMgmtExport(), 'SECU-DOC-MGMT-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function downloadAttFile(Request $request, $revSeq, $attSeq)
    {
        $item = SecuDocMgmt::where('REV_SEQ', $revSeq)->with(['att_file'])->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('HACCP Master File data not found')
            ]);
        }

        $att = AttFile::where('ATT_DTM', $item->ATT_DTM)->where('ATT_SEQ', $attSeq)->first();

        return response()->download(storage_path('app/' . $att->ATT_PATH), $att->ATT_NM);
    }
}
