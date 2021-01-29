<?php

namespace App\Http\Resources;

use App\CommCd;
use Illuminate\Http\Resources\Json\JsonResource;

class AppGetAllCcpMonitoringResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'idx' => $this->DEVICE,
            'device_nm' => CommCd::where('COMM1_CD', 'C00')->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_CD', $this->DEVICE)->value('COMM2_NM'),
            'data' => $this->DATA . $this->unit($this->DEVICE),
            'reg_dtm' => $this->REG_DTM
        ];
    }

    private function unit($device)
    {
        if (in_array($device, ['CHUMI1', 'RHUMI1', 'SIRIH1'])) {
            return '%';
        }
        return '℃';
    }
}
