<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppVersionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppVersionController extends Controller
{
    public function index(Request $request)
    {
        $appVer = $this->getAppVer();

        return new AppVersionResource($appVer);
    }

    public function update(Request $request)
    {
        $request->validate([
            'os' => 'required',
            'app_id' => 'required',
            'version' => 'required',
        ]);

        $appVer = $this->setAppVer($request->input('os'), $request->input('app_id'), $request->input('version'));

        return response()->json([
            'success' => true,
            'result' => new AppVersionResource($appVer)
        ]);
    }

    private function getAppVer()
    {
        if (!Storage::exists('app_version.json')) {
            Storage::put('app_version.json', '{"os": "AOS","app_id": "com.bokmansa.imasic","version": "1.0"}');
        }

        $content = file_get_contents(storage_path('app/app_version.json'));
        $json = json_decode($content);
        return $json;
    }

    private function setAppVer($os, $appId, $version)
    {
        Storage::put('app_version.json', json_encode([
            'os' => $os,
            'app_id' => $appId,
            'version' => $version,
        ]));

        return $this->getAppVer();
    }
}
