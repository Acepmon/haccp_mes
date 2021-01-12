<?php

namespace App\Http\Controllers\API;

use App\EdocFile;
use App\EdocFileHaccp;
use App\Http\Controllers\Controller;
use App\Http\Resources\EdocFileHaccpResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            $items = $items->whereHas('edoc_file', function ($query) use ($docNm) {
                $query->where('DOC_NM', 'LIKE', '%' . $docNm . '%');
            });
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

    public function qrWrite($docId) {
        $edocFile = EdocFile::where('DOC_ID', $docId)->with(['edoc_file_haccp'])->firstOrFail();
        return QRCode::text($edocFile->DOC_ID)->png();
    }

    public function qrApproval($docId) {
        $edocFile = EdocFile::where('DOC_ID', $docId)->with(['edoc_file_haccp'])->firstOrFail();
        return QRCode::text($edocFile->DOC_ID)->png();
    }

    public function preview($docId)
    {
        $edocFile = EdocFile::where('DOC_ID', $docId)->with(['edoc_file_haccp'])->firstOrFail();
        $preview = $edocFile->DOC_CONTENT;
        $preview = Str::replaceFirst("{qr_write}", "<img src='".route('api.edoc_file_haccp.qr_write', $docId)."' class='blank_box' />", $preview);
        $preview = Str::replaceFirst("{qr_approval}", "<img src='".route('api.edoc_file_haccp.qr_approval', $docId)."' class='blank_box' />", $preview);
        $preview = Str::replaceFirst("{date}", now()->format('Y-m-d'), $preview);

        return view('edoc_file_preview', [
            'preview' => $preview,
        ]);
    }
}
