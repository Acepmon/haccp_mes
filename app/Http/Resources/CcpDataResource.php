<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CcpDataResource extends JsonResource
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
            'ccp_seq' => $this->CCP_SEQ,
            'device_id' => $this->DEVICE_ID,
            'data' => $this->DATA,
            'reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
