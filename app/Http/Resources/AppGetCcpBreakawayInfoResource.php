<?php

namespace App\Http\Resources;

use App\CommCd;
use Illuminate\Http\Resources\Json\JsonResource;

class AppGetCcpBreakawayInfoResource extends JsonResource
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
            'device_nm' => CommCd::where('COMM1_CD', 'C00')->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_CD', $this->DEVICE_ID)->value('COMM2_NM'),
            'idx' => $this->DEVICE_ID . '-' . $this->SRC_CD . '-' . $this->SRT_DTM,
            'srt_dtm' => now()->parse($this->SRT_DTM)->format('Y-m-d H:i:s'),
            'esc_data' => $this->ESC_DATA . $this->unit($this->DEVICE_ID),
            'reason' => $this->REASON
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
