<?php

namespace App\Http\Controllers\API;

use App\EdocFile;
use App\EdocFileHaccp;
use App\Http\Controllers\Controller;
use App\Http\Resources\EdocFileHaccpResource;
use Illuminate\Http\Request;
use LaravelQRCode\Facades\QRCode;

class EdocFileHaccpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = EdocFileHaccp::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'WORK_DTM');
        $order = $request->input('order', 'DESC');

        if ($request->has('from') && !empty($request->input('from'))) {
            $from = $request->input('from');
            $items = $items->whereDate('WORK_DTM', '>=', now()->parse($from)->format('YmdHis'));
        }

        if ($request->has('to') && !empty($request->input('to'))) {
            $to = $request->input('to');
            $items = $items->whereDate('WORK_DTM', '<=', now()->parse($to)->format('YmdHis'));
        }

        if ($request->has('doc_nm') && !empty($request->input('doc_nm'))) {
            $docNm = $request->input('doc_nm');
            $items = $items->where('DOC_NM', 'LIKE', '%' . $docNm . '%');
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return EdocFileHaccpResource::collection($items);
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

    public function qrWrite($haccpSeq) {
        $edocFileHaccp = EdocFileHaccp::where('HACCP_SEQ', $haccpSeq)->firstOrFail();
        $qrData = $edocFileHaccp->WORK_DTM . '-' . $edocFileHaccp->WORK_ID;
        return QRCode::text($qrData)->png();
    }

    public function qrApproval($haccpSeq) {
        $edocFileHaccp = EdocFileHaccp::where('HACCP_SEQ', $haccpSeq)->firstOrFail();
        $qrData = $edocFileHaccp->APP_DTM . '-' . $edocFileHaccp->APP_ID;
        return QRCode::text($qrData)->png();
    }

    public function preview($haccpSeq)
    {
        $edocFileHaccp = EdocFileHaccp::where('HACCP_SEQ', $haccpSeq)->firstOrFail();
        $preview = $edocFileHaccp->previewHtml();

        return view('edoc_file_preview', [
            'preview' => $preview,
        ]);
    }
}
