<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MyhhResource extends JsonResource
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
            'myhh:myhh_id' => $this->MYHH_ID,
            'myhh:myhh_nm' => $this->MYHH_NM,
            'myhh:user_sts_yn' => $this->USER_STS_YN,
            'myhh:reg_dtm' => now()->parse($this->REG_DTM)->format('Y-m-d'),
        ];
    }
}
