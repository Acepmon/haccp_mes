<?php

namespace App\Http\Controllers\API;

use App\CompInfo;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompInfoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $item = CompInfo::with('haccp_user')->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Company info data not found')
            ]);
        }

        return new CompInfoResource($item);
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
            'comp_info:comp_id' => 'required|string|max:20',
            'comp_info:comp_nm' => 'required|string|max:60',
            'comp_info:ceo_nm' => 'required|string|max:60',
            'comp_info:tel_no' => 'nullable|string|max:20',
            'comp_info:fax_no' => 'nullable|string|max:20',
            'comp_info:url' => 'nullable|string|max:30',
            'comp_info:zip_cd' => 'nullable|string|max:20',
            'comp_info:addr1' => 'nullable|string|max:60',
            'comp_info:addr2' => 'nullable|string|max:60',
            'comp_info:haccp_id' => 'nullable|string|max:15|exists:user,USER_ID',
            'comp_info:haccp_item' => 'nullable|string|max:100',
        ]);

        if (CompInfo::count() > 0) {
            CompInfo::first()->update([
                'COMP_ID' => $request->input('comp_info:comp_id'),
                'COMP_NM' => $request->input('comp_info:comp_nm'),
                'CEO_NM' => $request->input('comp_info:ceo_nm'),
                'TEL_NO' => $request->input('comp_info:tel_no'),
                'FAX_NO' => $request->input('comp_info:fax_no'),
                'URL' => $request->input('comp_info:url'),
                'ZIP_CD' => $request->input('comp_info:zip_cd'),
                'ADDR1' => $request->input('comp_info:addr1'),
                'ADDR2' => $request->input('comp_info:addr2'),
                'HACCP_ID' => $request->input('comp_info:haccp_id'),
                'HACCP_ITEM' => $request->input('comp_info:haccp_item'),
            ]);
        } else {
            CompInfo::create([
                'COMP_ID' => $request->input('comp_info:comp_id'),
                'COMP_NM' => $request->input('comp_info:comp_nm'),
                'CEO_NM' => $request->input('comp_info:ceo_nm'),
                'TEL_NO' => $request->input('comp_info:tel_no'),
                'FAX_NO' => $request->input('comp_info:fax_no'),
                'URL' => $request->input('comp_info:url'),
                'ZIP_CD' => $request->input('comp_info:zip_cd'),
                'ADDR1' => $request->input('comp_info:addr1'),
                'ADDR2' => $request->input('comp_info:addr2'),
                'HACCP_ID' => $request->input('comp_info:haccp_id'),
                'HACCP_ITEM' => $request->input('comp_info:haccp_item'),
                'REG_ID' => Auth::check() ? Auth::user()->USER_ID : null,
                'REG_DTM' => now()->format('Ymdhis'),
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => new CompInfoResource(CompInfo::with('haccp_user')->first())
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
        $item = CompInfo::where('COMP_ID', $id)->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => __('Company info data not found')
            ]);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => __('Company info successfully deleted')
        ]);
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    // }
}
