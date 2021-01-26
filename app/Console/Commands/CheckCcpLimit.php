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
        $from = now()->subMinutes(1)->format('Ymdhis');

        $ccpDatas = CcpData::select('DEVICE_ID', 'DATA', 'REG_DTM')
            ->whereRaw('CAST(REG_DTM AS SIGNED) >= ' . intval($from))
            ->orderBy('REG_DTM', 'ASC')
            ->get();

        // dd($from, $ccpDatas->first()->REG_DTM, $ccpDatas->last()->REG_DTM, $ccpDatas->last()->DEVICE_ID);

        // $limits = CcpLimit::whereNotNull('LMT_UP')->whereNotNull('LMT_DN')->where('USE_YN', 'Y')->orderBy('DEVICE_ID', 'ASC')->get();
        $limits = CcpLimit::whereNotNull('LMT_UP')->whereNotNull('LMT_DN')->where('USE_YN', 'Y')->whereIn('DEVICE_ID', ['FREZFS', 'QUFRE1'])->orderBy('DEVICE_ID', 'ASC')->get();

        foreach ($limits as $limit) {
            if (empty($limit->LMT_UP) && empty($limit->LMT_DN)) {
                continue;
            }

            $filteredDatas = $ccpDatas->filter(function ($ccpData) use ($limit) {
                return $ccpData->DEVICE_ID == $limit->DEVICE_ID;
            });

            $flag = null;
            foreach ($filteredDatas as $data) {
                $val = floatval($data->DATA);
                $up = floatval($limit->LMT_UP);
                $dn = floatval($limit->LMT_DN);

                // if AU insert
                // if AD update
                // if BD insert
                // if BU update

                if ($flag == null) {
                    if ($val > $up && $up != 0) {
                        if (!CcpEscData::where('DEVICE_ID', $data->DEVICE_ID)->where('SRT_DTM', $data->REG_DTM)->exists()) {
                            $flag = CcpEscData::create([
                                'DEVICE_ID' => $data->DEVICE_ID,
                                'SRC_CD' => $limit->SRC_CD,
                                'SRT_DTM' => $data->REG_DTM,
                                'END_DTM' => null,
                                'ESC_DATA' => (float) number_format($data->DATA, 3),
                            ]);
    
                            event(new CcpLimitUpExceeded($flag));
                        }
                    }
                    else if ($val < $dn && $dn != 0) {
                        if (!CcpEscData::where('DEVICE_ID', $data->DEVICE_ID)->where('SRT_DTM', $data->REG_DTM)->exists()) {
                            $flag = CcpEscData::create([
                                'DEVICE_ID' => $data->DEVICE_ID,
                                'SRC_CD' => $limit->SRC_CD,
                                'SRT_DTM' => $data->REG_DTM,
                                'END_DTM' => null,
                                'ESC_DATA' => (float) number_format($data->DATA, 3),
                            ]);
    
                            event(new CcpLimitDnExceeded($flag));
                        }
                    }
                } else {
                    if ($val < $up && $up != 0) {
                        $flag->update(['END_DTM' => $data->REG_DTM]);

                        // event(new CcpLimitUpExceeded($flag));

                        $flag = null;
                    } 
                    else if ($val > $dn && $dn != 0) {
                        $flag->update(['END_DTM' => $data->REG_DTM]);

                        // event(new CcpLimitDnExceeded($flag));

                        $flag = null;
                    }
                }
            }
        }
    }
}
