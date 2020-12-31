<?php

namespace App\Http\Controllers\API;

use App\AttFile;
use App\Exports\SecuDocMgmtExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\SecuDocMgmtResource;
use App\SecuDocMgmt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SecuDocMgmtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = SecuDocMgmt::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'REG_DTM');
        $order = $request->input('order', 'DESC');

        if ($request->has('from_dt')) {
            $fromDt = $request->input('from_dt');
            $items = $items->where('FROM_DT', now()->parse($fromDt)->format('Ymd'));
        }

        if ($request->has('to_dt')) {
            $toDt = $request->input('to_dt');
            $items = $items->where('TO_DT', now()->parse($toDt)->format('Ymd'));
        }

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return SecuDocMgmtResource::collection($items);
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
            'secu_doc_mgmt:doc_nm' => 'required|string|max:100',
            'secu_doc_mgmt:doc_dt' => 'required|string|date_format:Y-m-d',
            'secu_doc_mgmt:from_dt' => 'required|string|date_format:Y-m-d',
            'secu_doc_mgmt:to_dt' => 'required|string|date_format:Y-m-d',
            'secu_doc_mgmt:att' => 'required|file',
        ]);

        $dtm = now()->format('Ymdhis');

        if ($request->hasFile('secu_doc_mgmt:att')) {
            $file = $request->file('secu_doc_mgmt:att');

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

        $item = SecuDocMgmt::create([
            'DOC_NM' => $request->input('secu_doc_mgmt:doc_nm'),
            'DOC_DT' => now()->parse($request->input('secu_doc_mgmt:doc_dt'))->format('Ymd'),
            'FROM_DT' => now()->parse($request->input('secu_doc_mgmt:from_dt'))->format('Ymd'),
            'TO_DT' => now()->parse($request->input('secu_doc_mgmt:to_dt'))->format('Ymd'),
            'ATT_DTM' => $request->hasFile('secu_doc_mgmt:att') ? $dtm : null,
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ]);

        return response()->json([
            'success' => true,
            'result' => new SecuDocMgmtResource(SecuDocMgmt::where('DOC_ID', $item->DOC_ID)->with(['att_file'])->first()),
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
        $item = SecuDocMgmt::where('DOC_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Security Document Management data not found')
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => new SecuDocMgmtResource($item),
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
        $item = SecuDocMgmt::where('DOC_ID', $id)->with(['att_file'])->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Security Document Management data not found')
            ]);
        }

        $request->validate([
            'secu_doc_mgmt:doc_nm' => 'required|string|max:100',
            'secu_doc_mgmt:doc_dt' => 'required|string|date_format:Y-m-d',
            'secu_doc_mgmt:from_dt' => 'required|string|date_format:Y-m-d',
            'secu_doc_mgmt:to_dt' => 'required|string|date_format:Y-m-d',
            'secu_doc_mgmt:att' => 'nullable|file',
        ]);

        $dtm = now()->format('Ymdhis');

        if ($request->hasFile('secu_doc_mgmt:att')) {
            $file = $request->file('secu_doc_mgmt:att');

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
            'DOC_NM' => $request->input('secu_doc_mgmt:doc_nm'),
            'DOC_DT' => now()->parse($request->input('secu_doc_mgmt:doc_dt'))->format('Ymd'),
            'FROM_DT' => now()->parse($request->input('secu_doc_mgmt:from_dt'))->format('Ymd'),
            'TO_DT' => now()->parse($request->input('secu_doc_mgmt:to_dt'))->format('Ymd'),
            'ATT_DTM' => $request->hasFile('secu_doc_mgmt:att') ? $dtm : $item->ATT_DTM,
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ]);

        return response()->json([
            'success' => true,
            'result' => new SecuDocMgmtResource(SecuDocMgmt::where('DOC_ID', $id)->with(['att_file'])->first()),
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
        $item = SecuDocMgmt::where('DOC_ID', $id)->with(['att_file'])->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Security Document Management data not found')
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
            'result' => __('Security Document Management data successfully deleted'),
        ]);
    }

    public function download(Request $request)
    {
        $fromDt = $request->input('from_dt');
        $toDt = $request->input('to_dt');

        return Excel::download(new SecuDocMgmtExport($fromDt, $toDt), 'SECU-DOC-MGMT-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function downloadAttFile(Request $request, $docId, $attSeq)
    {
        $item = SecuDocMgmt::where('DOC_ID', $docId)->with(['att_file'])->first();

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
