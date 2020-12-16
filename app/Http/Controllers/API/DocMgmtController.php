<?php

namespace App\Http\Controllers\API;

use App\AttFile;
use App\DocMgmt;
use App\Exports\DocMgmtExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\DocMgmtResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DocMgmtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = DocMgmt::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'reg_dtm');
        $order = $request->input('order', 'desc');

        if ($request->has('doc_nm')) {
            $docNm = $request->input('doc_nm');
            $items = $items->where('doc_nm', 'LIKE', '%'.$docNm.'%');
        }

        if ($request->has('doc_desc')) {
            $docDesc = $request->input('doc_desc');
            $items = $items->where('doc_desc', 'LIKE', '%'.$docDesc.'%');
        }

        if ($request->has('type_cd')) {
            $type_cd = $request->input('type_cd');
            $items = $items->where('type_cd', $type_cd);
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return DocMgmtResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'doc_mgmt:type_cd' => 'required|string|max:20',
            'doc_mgmt:doc_nm' => 'required|string|max:100',
            'doc_mgmt:doc_desc' => 'nullable|string|max:150',
            'doc_mgmt:att' => 'required|file',
        ]);

        $dtm = now()->format('Ymdhis');

        if ($request->hasFile('doc_mgmt:att')) {
            $file = $request->file('doc_mgmt:att');

            // foreach ($files as $index => $file) {
                $path = $file->store('files');

                AttFile::create([
                    'ATT_DTM' => $dtm,
                    'ATT_SEQ' => 1,
                    'ATT_NM' => $file->getClientOriginalName(),
                    'ATT_PATH' => $path,
                    'FILE_SZ' => Storage::size($path),
                    'RMK' => null,
                ]);
            // }
        } else {
            return response()->json([
                'success' => false,
                'message' => __('Attachment upload failed'),
            ], 422);
        }

        $item = DocMgmt::create([
            'TYPE_CD' => $request->input('doc_mgmt:type_cd'),
            'DOC_NM' => $request->input('doc_mgmt:doc_nm'),
            'DOC_DESC' => $request->input('doc_mgmt:doc_desc'),
            'ATT_DTM' => $request->hasFile('doc_mgmt:att') ? $dtm : null,
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ]);

        return response()->json([
            'success' => true,
            'result' => new DocMgmtResource(DocMgmt::where('DOC_ID', $item->DOC_ID)->with(['att_file'])->first()),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = DocMgmt::where('DOC_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Document Management data not found')
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => new DocMgmtResource($item),
        ]);
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
        $item = DocMgmt::where('DOC_ID', $id)->with(['att_file'])->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Document Management data not found')
            ]);
        }

        $request->validate([
            'doc_mgmt:type_cd' => 'required|string|max:20',
            'doc_mgmt:doc_nm' => 'required|string|max:100',
            'doc_mgmt:doc_desc' => 'nullable|string|max:150',
            'doc_mgmt:att' => 'nullable|file',
        ]);

        $dtm = now()->format('Ymdhis');

        if ($request->hasFile('doc_mgmt:att')) {
            $file = $request->file('doc_mgmt:att');

            if ($item->att_file->count() > 0) {
                $item->att_file->each(function ($att) {
                    if (Storage::exists($att->ATT_PATH)) {
                        Storage::delete($att->ATT_PATH);
                    }
                });
                $item->att_file()->delete();
            }

            // foreach ($files as $index => $file) {
                $path = $file->store('files');

                AttFile::create([
                    'ATT_DTM' => $dtm,
                    'ATT_SEQ' => 1,
                    'ATT_NM' => $file->getClientOriginalName(),
                    'ATT_PATH' => $path,
                    'FILE_SZ' => Storage::size($path),
                    'RMK' => null,
                ]);
            // }
        }

        $item->update([
            'TYPE_CD' => $request->input('doc_mgmt:type_cd'),
            'DOC_NM' => $request->input('doc_mgmt:doc_nm'),
            'DOC_DESC' => $request->input('doc_mgmt:doc_desc'),
            'ATT_DTM' => $request->hasFile('doc_mgmt:att') ? $dtm : $item->ATT_DTM,
        ]);

        return response()->json([
            'success' => true,
            'result' => new DocMgmtResource(DocMgmt::where('DOC_ID', $id)->with(['att_file'])->first()),
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
        $item = DocMgmt::where('DOC_ID', $id)->with(['att_file'])->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Document Management data not found')
            ]);
        }

        if ($item->att_file->count() > 0) {
            if ($item->att_file->count() > 0) {
                $item->att_file->each(function ($att) {
                    if (Storage::exists($att->ATT_PATH)) {
                        Storage::delete($att->ATT_PATH);
                    }
                });
                $item->att_file()->delete();
            }
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'result' => __('Document Management data successfully deleted'),
        ]);
    }

    public function download(Request $request)
    {
        return Excel::download(new DocMgmtExport(), 'DOC-MGMT-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function downloadAttFile(Request $request, $docId, $attSeq)
    {
        $item = DocMgmt::where('DOC_ID', $docId)->with(['att_file'])->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Document Management data not found')
            ]);
        }

        $att = AttFile::where('ATT_DTM', $item->ATT_DTM)->where('ATT_SEQ', $attSeq)->first();

        return response()->download(storage_path('app/' . $att->ATT_PATH), $att->ATT_NM);
    }
}
