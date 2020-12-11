<?php

namespace App\Http\Controllers\API;

use App\AttFile;
use App\Exports\HaccpMstFileExport;
use App\HaccpMstFile;
use App\Http\Controllers\Controller;
use App\Http\Resources\HaccpMstFileResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class HaccpMstFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = HaccpMstFile::query();

        $with = array_filter(explode(',', $request->input('with')));
        $limit = $request->input('limit', 15);
        $sort = $request->input('sort', 'reg_dtm');
        $order = $request->input('order', 'asc');

        if ($limit == -1) {
            $items = $items->with($with)->orderBy($sort, $order)->get();
        } else {
            $items = $items->with($with)->orderBy($sort, $order)->paginate($limit);
        }

        return HaccpMstFileResource::collection($items);
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
            'rev_no' => 'required|string|max:10',
            'rev_dt' => 'required|string|date_format:Y-m-d',
            'att' => 'required|file',
            'rev_content' => 'nullable|string|max:100',
            'rev_reason' => 'nullable|string|max:100',
        ]);

        $dtm = now()->format('Ymdhis');

        if ($request->hasFile('att')) {
            $files = $request->file('att');

            foreach ($files as $index => $file) {
                $path = $file->store('files');

                AttFile::create([
                    'ATT_DTM' => $dtm,
                    'ATT_SEQ' => ($index + 1),
                    'ATT_NM' => $file->getClientOriginalName(),
                    'ATT_PATH' => $path,
                    'FILE_SZ' => Storage::size($path),
                    'RMK' => null,
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => __('Attachment upload failed'),
            ], 422);
        }

        $item = HaccpMstFile::create([
            'REV_NO' => $request->input('rev_no'),
            'REV_DT' => now()->parse($request->input('rev_dt'))->format('Ymd'),
            'ATT_DTM' => $request->hasFile('att') ? $dtm : null,
            'REV_CONTENT' => $request->input('rev_content'),
            'REV_REASON' => $request->input('rev_reason'),
            'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
            'REG_DTM' => now()->format('Ymdhis'),
        ]);

        return response()->json([
            'success' => true,
            'result' => new HaccpMstFileResource(HaccpMstFile::where('REV_SEQ', $item->REV_SEQ)->with(['att_file'])->first()),
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
        $item = HaccpMstFile::where('REV_SEQ', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('HACCP Master File data not found')
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => new HaccpMstFileResource($item),
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
        $item = HaccpMstFile::where('REV_SEQ', $id)->with(['att_file'])->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('HACCP Master File data not found')
            ]);
        }

        $request->validate([
            'rev_no' => 'required|string|max:10',
            'rev_dt' => 'required|string|date_format:Y-m-d',
            'att.*' => 'nullable|file',
            'rev_content' => 'nullable|string|max:100',
            'rev_reason' => 'nullable|string|max:100',
        ]);

        $dtm = now()->format('Ymdhis');

        if ($request->hasFile('att')) {
            $files = $request->file('att');

            if ($item->att_file->count() > 0) {
                $item->att_file->each(function ($att) {
                    if (Storage::exists($att->ATT_PATH)) {
                        Storage::delete($att->ATT_PATH);
                    }
                });
                $item->att_file()->delete();
            }

            foreach ($files as $index => $file) {
                $path = $file->store('files');

                AttFile::create([
                    'ATT_DTM' => $dtm,
                    'ATT_SEQ' => ($index + 1),
                    'ATT_NM' => $file->getClientOriginalName(),
                    'ATT_PATH' => $path,
                    'FILE_SZ' => Storage::size($path),
                    'RMK' => null,
                ]);
            }
        }

        $item->update([
            'REV_NO' => $request->input('rev_no'),
            'REV_DT' => now()->parse($request->input('rev_dt'))->format('Ymd'),
            'ATT_DTM' => $request->hasFile('att') ? $dtm : $item->ATT_DTM,
            'REV_CONTENT' => $request->input('rev_content'),
            'REV_REASON' => $request->input('rev_reason')
        ]);

        return response()->json([
            'success' => true,
            'result' => new HaccpMstFileResource(HaccpMstFile::where('REV_SEQ', $id)->with(['att_file'])->first()),
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
        $item = HaccpMstFile::where('REV_SEQ', $id)->with(['att_file'])->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('HACCP Master File data not found')
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
            'result' => __('Haccp Master File data successfully deleted'),
        ]);
    }

    public function download(Request $request)
    {
        return Excel::download(new HaccpMstFileExport(), 'HACCP-MST-FILE-' . now()->format('Y-m-d') . '.xlsx');
    }
}
