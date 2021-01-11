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
            'ccp_esc_data:srt_dtm' => $this->SRT_DTM,
            'ccp_esc_data:end_dtm' => $this->END_DTM,
            'ccp_esc_data:reason' => $this->REASON,
        ];
    }
}
