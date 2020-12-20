<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommCdResource extends JsonResource
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
            'comm_cd:comm1_cd' => $this->COMM1_CD,
            'comm_cd:comm2_cd' => $this->COMM2_CD,
            'comm_cd:comm2_nm' => $this->COMM2_NM,
            'comm_cd:reg_id' => $this->REG_ID,
            'comm_cd:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
