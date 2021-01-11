<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CcpLimitResource extends JsonResource
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
            'ccp_limit:device_id' => $this->DEVICE_ID,
            'ccp_limit:lmt_up' => $this->LMT_UP,
            'ccp_limit:lmt_dn' => $this->LMT_DN,
            'ccp_limit:remark' => $this->REMARK,
            'ccp_limit:reg_id' => $this->REG_ID,
            'ccp_limit:reg_dtm' => $this->REG_DTM,
        ];
    }
}
