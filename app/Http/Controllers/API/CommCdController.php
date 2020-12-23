<?php

namespace App\Http\Controllers\API;

use App\CommCd;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommCdResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommCdController extends Controller
{
    public function code(Request $request)
    {
        $cd1 = $request->input('cd1');
        $cd2 = $request->input('cd2');

        if ($request->has('cd2')) {
            if ($this->getCodeNameExists()) {
                $items = DB::select('select get_codename(?, ?) as comm2_nm', [$cd1, $cd2]);
            } else {
                $items = CommCd::select('comm2_cd', 'comm2_nm')->where('comm1_cd', $cd1)->whereNotIn('comm2_cd', ['$$'])->where('comm2_cd', $cd2)->get();
            }
        } else {
            if ($this->getCodeListExists()) {
                $items = DB::select('call get_codelist(?)', [$cd1]);
            } else {
                $items = CommCd::select('comm2_cd', 'comm2_nm')->where('comm1_cd', $cd1)->whereNotIn('comm2_cd', ['$$'])->get();
            }
        }

        return response()->json($items);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 15);
        $items = CommCd::query();

        if ($request->has('comm1_cd')) {
            $items = $items->where('COMM1_CD', $request->input('comm1_cd'))->whereNotIn('COMM2_CD', ['$$']);
        }

        if ($request->has('comm2_nm')) {
            $items = $items->where('COMM2_NM', 'LIKE', '%'.$request->input('comm2_nm').'%')->whereIn('COMM2_CD', ['$$']);
        }

        if ($limit == -1) {
            $items = $items->get();
        } else {
            $items = $items->paginate($limit);
        }

        return CommCdResource::collection($items);
    }

    private function getCodeListExists() {
        return DB::table('information_schema.ROUTINES')->where('ROUTINE_SCHEMA', config('database.connections.mysql.database'))->where('ROUTINE_NAME', 'get_codelist')->exists();
    }

    private function getCodeNameExists() {
        return DB::table('information_schema.ROUTINES')->where('ROUTINE_SCHEMA', config('database.connections.mysql.database'))->where('ROUTINE_NAME', 'get_codename')->exists();
    }

    public function sync(Request $request, $comm1cd)
    {
        $items = CommCd::query();

        $items = $items->where('COMM1_CD', $comm1cd)->whereNotIn('COMM2_CD', ['$$']);

        return CommCdResource::collection($items->get());
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
}
