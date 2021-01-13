<?php

namespace App\Jobs;

use App\CcpData;
use App\CcpEscData;
use App\CcpLimit;
use App\Events\CcpLimitDnExceeded;
use App\Events\CcpLimitUpExceeded;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckCcpLimit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $from = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->from = now()->subMinutes(5)->format('Ymdhis');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ccpLimits = CcpLimit::all();
        $ccpDatas = CcpData::select('DEVICE_ID', 'DATA', 'REG_DTM')
            ->whereRaw('CAST(REG_DTM AS SIGNED) >= ' . intval($this->from))
            ->whereIn('DEVICE_ID', $ccpLimits->pluck('DEVICE_ID')->toArray())
            ->get();

        foreach ($ccpDatas as $data) {
            foreach ($ccpLimits as $limit) {
                if ($limit->LMT_UP <= 0 && $limit->LMT_DN) {
                    continue;
                }

                if ($data->DEVICE_ID == $limit->DEVICE_ID) {
                    if (floatval($data->DATA) > intval($limit->LMT_UP)) {
                        $this->insertCcpEscData($limit->DEVICE_ID, now()->parse($data->REG_DTM)->format('Ymdhi'), null, $limit->REMARK);
                        event(new CcpLimitUpExceeded($limit));
                    }

                    if (floatval($data->DATA) < intval($limit->LMT_DN)) {
                        $this->insertCcpEscData($limit->DEVICE_ID, now()->parse($data->REG_DTM)->format('Ymdhi'), null, $limit->REMARK);
                        event(new CcpLimitDnExceeded($limit));
                    }
                }
            }
        }
    }

    private function insertCcpEscData($deviceId, $srtDtm, $endDtm = null, $reason = null)
    {
        $srtDtm = now()->parse($srtDtm)->format('Ymdhis');

        if (!CcpEscData::where('DEVICE_ID', $deviceId)->where('SRT_DTM', $srtDtm)->exists()) {
            CcpEscData::create([
                'DEVICE_ID' => $deviceId,
                'SRT_DTM' => $srtDtm,
                'END_DTM' => $endDtm,
                'REASON' => $reason,
            ]);
        }
    }
}
