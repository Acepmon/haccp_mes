<?php

namespace App\Console\Commands;

use App\CcpData;
use App\CcpEscData;
use App\CcpLimit;
use App\Events\CcpLimitDnExceeded;
use App\Events\CcpLimitUpExceeded;
use App\Jobs\CheckCcpLimit as JobsCheckCcpLimit;
use Illuminate\Console\Command;

class CheckCcpLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ccp:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for CCP data for any limit exceed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $from = now()->subHours(24)->format('Ymdhis');

        CcpEscData::truncate();

        $ccpDatas = CcpData::select('DEVICE_ID', 'DATA', 'REG_DTM')
            ->whereRaw('CAST(REG_DTM AS SIGNED) >= ' . intval($from))
            ->orderBy('REG_DTM', 'ASC')
            ->get();

        foreach (CcpLimit::whereNotNull('LMT_UP')->whereNotNull('LMT_DN')->orderBy('DEVICE_ID', 'ASC')->get() as $limit) {
            if (empty($limit->LMT_UP) && empty($limit->LMT_DN)) {
                continue;
            }

            $filteredDatas = $ccpDatas->filter(function ($ccpData) use ($limit) {
                return $ccpData->DEVICE_ID == $limit->DEVICE_ID;
            });

            foreach ($filteredDatas as $key => $data) {
                $escData = CcpEscData::where('DEVICE_ID', $limit->DEVICE_ID)->whereNull('END_DTM')->first();

                if (!empty($limit->LMT_UP)) {
                    if (floatval($data->DATA) > floatval($limit->LMT_UP)) {
                        if ($escData == null) {
                            if (!CcpEscData::where('DEVICE_ID', $data->DEVICE_ID)->where('SRT_DTM', $data->REG_DTM)->exists()) {
                                CcpEscData::create([
                                    'DEVICE_ID' => $data->DEVICE_ID,
                                    'SRT_DTM' => $data->REG_DTM,
                                    'END_DTM' => null,
                                    'REASON' => null,
                                ]);

                                event(new CcpLimitUpExceeded($limit));
                            }
                        }
                    } else {
                        if ($escData != null) {
                            $escData->update([
                                'END_DTM' => $data->REG_DTM
                            ]);

                            event(new CcpLimitUpExceeded($limit));
                        }
                    }
                }

                // if d1 > up flag
                // else if d1 < up rm flag
                // else if d1 < dn flag
                // else if d1 > dn rm flag

                // if (!empty($limit->LMT_DN)) {
                //     if (floatval($data->DATA) < floatval($limit->LMT_DN)) {
                //         if ($escData == null) {
                //             if (!CcpEscData::where('DEVICE_ID', $data->DEVICE_ID)->where('SRT_DTM', $data->REG_DTM)->exists()) {
                //                 CcpEscData::create([
                //                     'DEVICE_ID' => $data->DEVICE_ID,
                //                     'SRT_DTM' => $data->REG_DTM,
                //                     'END_DTM' => null,
                //                     'REASON' => $limit->REMARK,
                //                 ]);

                //                 event(new CcpLimitDnExceeded($limit));
                //             }
                //         }
                //     } else {
                //         if ($escData != null) {
                //             $escData->update([
                //                 'END_DTM' => $data->REG_DTM
                //             ]);

                //             event(new CcpLimitDnExceeded($limit));
                //         }
                //     }
                // }
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
