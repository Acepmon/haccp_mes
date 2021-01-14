<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CcpEscDataResource extends JsonResource
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
            'ccp_esc_data:device_id' => $this->DEVICE_ID,
            'ccp_esc_data:device_nm' => $this->whenLoaded('device', function () {
                return $this->device->COMM2_NM;
            }),
            'ccp_esc_data:srt_dtm' => $this->SRT_DTM,
            'ccp_esc_data:srt_dtm_parsed' => $this->SRT_DTM ? now()->parse($this->SRT_DTM)->format('Y-m-d H:i:s') : null,
            'ccp_esc_data:end_dtm' => $this->END_DTM,
            'ccp_esc_data:end_dtm_parsed' => $this->END_DTM ? now()->parse($this->END_DTM)->format('Y-m-d H:i:s') : null,
            'ccp_esc_data:reason' => $this->REASON,
            'ccp_esc_data:esc_data' => $this->ESC_DATA,

            $this->mergeWhen($this->whenLoaded('ccp_limit'), new CcpLimitResource($this->ccp_limit)),
        ];
    }
}
