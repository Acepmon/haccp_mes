<?php

namespace App\Http\Controllers\API;

use App\EdocFile;
use App\Exports\EdocFileExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\EdocFileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use LaravelQRCode\Facades\QRCode;
use Maatwebsite\Excel\Facades\Excel;

class EdocFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = EdocFile::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'UPD_DTM');
        $order = $request->input('order', 'DESC');

        if ($request->has('doc_nm')) {
            $docNm = $request->input('doc_nm');
            $items = $items->where('DOC_NM', 'LIKE', '%'.$docNm.'%');
        }

        if ($request->has('type_cd')) {
            $typeCd = $request->input('type_cd');
            $items = $items->where('TYPE_CD', $typeCd);
        }

        if ($request->has('use_yn')) {
            $useYn = $request->input('use_yn');
            $items = $items->where('USE_YN', $useYn);
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return EdocFileResource::collection($items);
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
        $item = EdocFile::where('DOC_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('eDoc file not found')
            ]);
        }

        $request->validate([
            'edoc_file:type_cd' => 'required|string|max:20',
            'edoc_file:doc_nm' => 'required|string|max:100',
            'edoc_file:doc_desc' => 'nullable|string|max:150',
            'edoc_file:period_cd' => 'required|string|max:20',
            'edoc_file:period_data' => 'nullable|array',
            'edoc_file:use_yn' => 'required|string|in:' . implode(',', EdocFile::USE_ARRAY),
            'edoc_file:work_id' => 'required|string|max:20',
            'edoc_file:app_id' => 'required|string|max:20',
        ]);

        $item->update([
            'TYPE_CD' => $request->input('edoc_file:type_cd'),
            'DOC_NM' => $request->input('edoc_file:doc_nm'),
            'DOC_DESC' => $request->input('edoc_file:doc_desc'),
            'PERIOD_CD' => $request->input('edoc_file:period_cd'),
            'PERIOD_DATA' => implode(',', $request->input('edoc_file:period_data')),
            'USE_YN' => $request->input('edoc_file:use_yn'),
            'WORK_ID' => $request->input('edoc_file:work_id'),
            'APP_ID' => $request->input('edoc_file:app_id'),
            'UPD_DTM' => now()->format('Ymdhis'),
        ]);

        return response()->json([
            'success' => true,
            'result' => new EdocFileResource(EdocFile::where('DOC_ID', $id)->first()),
        ]);
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
        $docNm = $request->input('doc_nm');
        $typeCd = $request->input('type_cd');
        $useYn = $request->input('use_yn');

        return Excel::download(new EdocFileExport($docNm, $typeCd, $useYn), 'EDOC-FILE-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function qrWrite($docId) {
        $edocFile = EdocFile::where('DOC_ID', $docId)->with(['edoc_file_haccp'])->firstOrFail();
        return QRCode::text($edocFile->DOC_NM)->png();
    }

    public function qrApproval($docId) {
        $edocFile = EdocFile::where('DOC_ID', $docId)->with(['edoc_file_haccp'])->firstOrFail();
        return QRCode::text($edocFile->DOC_NM)->png();
    }

    public function preview($docId)
    {
        $edocFile = EdocFile::where('DOC_ID', $docId)->with(['edoc_file_haccp'])->firstOrFail();
        $preview = $edocFile->previewHtml();

        return view('edoc_file_preview', [
            'preview' => $preview,
        ]);
    }
}
