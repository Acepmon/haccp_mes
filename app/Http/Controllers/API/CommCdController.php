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
                $items = DB::select('select get_codename(?, ?) as COMM2_NM', [$cd1, $cd2]);
                dd($items);
            } else {
                $items = CommCd::select('COMM2_CD', 'COMM2_NM')->where('COMM1_CD', $cd1)->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_CD', $cd2)->get();
            }
        } else {
            if ($this->getCodeListExists()) {
                $items = DB::select('call get_codelist(?)', [$cd1]);
            } else {
                $items = CommCd::select('COMM2_CD', 'COMM2_NM')->where('COMM1_CD', $cd1)->whereNotIn('COMM2_CD', ['$$'])->get();
            }
        }

        return response()->json($this->map($items));
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
        } else if ($request->has('comm2_nm')) {
            $items = $items->where('COMM2_NM', 'LIKE', '%'.$request->input('comm2_nm').'%')->whereIn('COMM2_CD', ['$$']);
        } else {
            $items = $items->whereIn('COMM2_CD', ['$$']);
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

        $request->validate([
            'rowData' => 'required|array'
        ]);

        $datas = collect($request->input('rowData'))->map(function ($item) {
            return [
                'COMM1_CD' => $item['comm_cd:comm1_cd'],
                'COMM2_CD' => $item['comm_cd:comm2_cd'],
                'COMM2_NM' => $item['comm_cd:comm2_nm'],
            ];
        })->each(function ($item) use ($comm1cd) {
            DB::table('COMM_CD')
                ->where('COMM1_CD', $comm1cd)
                ->whereNotIn('COMM2_CD', ['$$'])
                ->where('COMM2_CD', $item['COMM2_CD'])
                ->update($item);
        });

        return response()->json([
            'success' => true,
            'message' => __('Successfully synced'),
        ]);
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

    private function map($items = [])
    {
        return array_map(function ($item) {
            $cd = (array) $item;
            $rt = [];

            if (array_key_exists('COMM1_CD', $cd)) {
                $rt['comm1_cd'] = $cd['COMM1_CD'];
            }
            if (array_key_exists('COMM2_CD', $cd)) {
                $rt['comm2_cd'] = $cd['COMM2_CD'];
            }
            if (array_key_exists('COMM2_NM', $cd)) {
                $rt['comm2_nm'] = $cd['COMM2_NM'];
            }

            return $rt;
        }, $items);
    }
}
